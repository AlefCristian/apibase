<?php

namespace Frota\Controllers;

use Frota\Models\FrotaModel;
use CodeIgniter\RESTful\ResourceController;
use \DateTime;

class FrotaController extends ResourceController {
    protected $modelName = FrotaModel::class;
    protected $format = 'json';

    // POST /api/frota/saida
    public function create() {
        $data = $this->request->getJSON(true);

        // Campos obrigatórios mínimos
        if (!isset($data['nome_motorista'], $data['local_destino'], $data['horario_saida'], $data['km_saida'], $data['horario_retorno'], $data['km_retorno'])) {
            return $this->failValidationErrors('Registro incompleto');
        }

        $datahorasaida = $data['data_saida'] . ' ' . $data['horario_saida'];
        $datahoraretorno = $data['data_saida'] . ' ' . $data['horario_retorno'];

        // Cria um DateTime a partir do formato brasileiro
        $dateTimeSaida = DateTime::createFromFormat('d-m-Y H:i', $datahorasaida);
        $dateTimeRetorno = DateTime::createFromFormat('d-m-Y H:i', $datahoraretorno);

        // Verifica se o parse foi bem-sucedido
        if (!$dateTimeSaida || !$dateTimeRetorno) {
            return $this->failValidationErrors('Data ou hora inválida.' . ' ' . $data['horario_saida']);
        }

        // Os campos de retorno são opcionais
        $frotaData = [
            'nome_motorista' => $data['nome_motorista'],
            'local_destino' =>$data['destino'],
            'horario_saida' =>  $dateTimeSaida->format('Y-m-d H:i:s'),
            'km_saida' => $data['km_saida'],
            'horario_retorno' =>  $dateTimeRetorno->format('Y-m-d H:i:s'),
            'km_retorno' => $data['km_retorno'] ?? null,
        ];

        $id = $this->model->insert($frotaData);

        if ($id === false || is_null($id)) {
            return $this->failServerError('Erro ao salvar no banco de dados');
        }       

        return $this->respondCreated([
            'message' => 'Registro de frota criado com sucesso.',
            'id' => $id,
        ]);
    }

    // PUT /api/frota/{id}/retorno
    public function update($id = null) {
        $data = $this->request->getJSON(true);

        if (!isset($data['horario_retorno'], $data['km_retorno'])) {
            return $this->failValidationErrors('Campos obrigatórios: horario_retorno, km_retorno');
        }

        $registro = $this->model->find($id);

        if (!$registro) {
            return $this->failNotFound("Registro com ID $id não encontrado.");
        }

        $this->model->update($id, $data);
        return $this->respond(['message' => 'Retorno registrado com sucesso']);
    }

    public function getUltimaSaidaSemRetorno() {
        try {
            $res = $this->model->where('horario_retorno', null)
                               ->where('km_retorno', null)
                               ->orderBy('id', 'desc')
                               ->first();

            if (!$res) {
                return $this->failNotFound('Não foi encontrada nenhuma saída sem retorno');
            }

            return $this->respond($res);
        } catch (\Throwable $e) {
            return $this->failServerError('Erro interno: ' . $e->getMessage());
        }
    }

    public function teste() {
        return $this->respond(['message' => 'Teste realizado com sucesso!']);
    }
}