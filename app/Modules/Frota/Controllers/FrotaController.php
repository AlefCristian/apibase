<?php

namespace Frota\Controllers;

use Frota\Models\FrotaModel;
use CodeIgniter\RESTful\ResourceController;

class FrotaController extends ResourceController {
    protected $modelName = FrotaModel::class;
    protected $format = 'json';

    // POST /api/frota/saida
    public function create() {
        $data = $this->request->getJSON(true);

        // Campos obrigatórios mínimos
        if (!isset($data['nome_motorista'], $data['horario_saida'], $data['km_saida'])) {
            return $this->failValidationErrors('Campos obrigatórios: nome_motorista, horario_saida, km_saida');
        }

        // Os campos de retorno são opcionais
        $frotaData = [
            'nome_motorista' => $data['nome_motorista'],
            'horario_saida' => $data['horario_saida'],
            'km_saida' => $data['km_saida'],
            'horario_retorno' => $data['horario_retorno'] ?? null,
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