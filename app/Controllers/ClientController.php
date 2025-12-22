<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ClientModel;

class ClientController extends ResourceController
{
    protected $modelName = ClientModel::class;
    protected $format    = 'json';

     /**
 * GET /api/clientes
 * Schema da entidade Clientes
 */
public function index()
{
    return $this->respond([
        'title'        => 'Clientes',
        'listEndpoint' => '/api/clientes/lista',
        'formEndpoint' => '/api/clientes',
        'primaryKey'   => 'clientId',

        'columns' => [
            [
                'title'     => 'Nome',
                'dataIndex' => 'clientName',
            ],
            [
                'title'     => 'Email',
                'dataIndex' => 'clientEmail',
            ],
            [
                'title'     => 'Telefone',
                'dataIndex' => 'clientPhoneNumber',
            ],
        ],

        // 👇 AGORA O QUE FALTAVA
        'fields' => [
            [
                'name'     => 'clientName',
                'label'    => 'Nome',
                'type'     => 'text',
                'required' => true,
            ],
            [
                'name'     => 'clientEmail',
                'label'    => 'Email',
                'type'     => 'email',
                'required' => true,
            ],
            [
                'name'     => 'clientPhoneNumber',
                'label'    => 'Telefone',
                'type'     => 'text',
                'required' => false,
            ],
            [
                'name'     => 'clientCpf',
                'label'    => 'CPF',
                'type'     => 'text',
                'required' => false,
            ],
        ],

        'actions' => [
            [
                'key'   => 'edit',
                'label' => 'Editar',
                'type'  => 'link',
            ],
            [
                'key'    => 'delete',
                'label'  => 'Excluir',
                'type'   => 'link',
                'danger' => true,
                'confirm' => [
                    'title'   => 'Confirmar exclusão',
                    'content' => 'Deseja realmente excluir este cliente?',
                ],
            ],
        ],
    ]);
}

    /**
 * GET /api/clientes/lista
 */
public function read()
{
    return $this->respond(
        $this->model->findAll()
    );
}


    /**
     * POST /api/clientes
     */
    public function create()
    {
        $requestData = $this->request->getJSON(true);

        if (!$requestData) {
            return $this->fail('JSON inválido ou não enviado');
        }

        if (!$this->model->insert($requestData)) {
            return $this->failValidationErrors(
                $this->model->errors()
            );
        }

        return $this->respondCreated([
            'success' => true,
            'message' => 'Cliente cadastrado com sucesso',
            'id'      => $this->model->getInsertID(),
        ]);
    }

    /**
     * PUT /api/clientes/{id}
     */
    public function update($id = null)
    {
        if (!$id) {
            return $this->fail('ID do cliente não informado');
        }

        $requestData = $this->request->getJSON(true);

        if (!$requestData) {
            return $this->fail('JSON inválido ou não enviado');}

        $data = [
            ClientModel::NAME        => $requestData['nome']     ?? null,
            ClientModel::EMAIL       => $requestData['email']    ?? null,
            ClientModel::PHONENUMBER => $requestData['telefone'] ?? null,
            ClientModel::CPF         => $requestData['cpf']      ?? null,
        ];

        if (!$this->model->update($id, $data)) {
            return $this->failValidationErrors(
                $this->model->errors()
            );
        }

        return $this->respond([
            'success' => true,
            'message' => "Cliente {$id} atualizado com sucesso",
        ]);
    }

    /**
     * DELETE /api/clientes/{id}
     */
    public function delete($id = null)
    {
        if (!$id) {
            return $this->fail('ID do cliente não informado');
        }

        if (!$this->model->delete($id)) {
            return $this->fail('Erro ao excluir cliente');
        }

        return $this->respond([
            'success' => true,
            'message' => "Cliente {$id} removido com sucesso",
        ]);
    }
}
