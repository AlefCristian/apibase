<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;

class Auth extends ResourceController {
    protected $format = 'json';

    public function register() {
        $rules = [
            'username' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $model = new UserModel();

        $data = [
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];

        $model->save($data);
        return $this->respondCreated(['message' => 'Usuário registrado com sucesso']);
    }

    public function login() {
        #var_dump(getenv('JWT_SECRET')); die;

        $model = new UserModel();

        $data = $this->request->getJSON();

        if (!$data || (!isset($data->username) && !isset($data->email)) || !isset($data->password)) {
            return $this->failValidationErrors('Dados inválidos.');
        }


        $username = $data->username ?? null;
        $email = $data->email ?? null;
        $password = $data->password ?? null;
        // $email = $this->request->getVar('email');
        // $username = $this->request->getVar('username');
        // $password = $this->request->getVar('password');

        $user = $model->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Usuario ou senha inválidos.');
        }

        $payload = [
            'sub' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'iat' => time(),
            'exp' => time() + 3600 // 1 hora
        ];

        $key = getenv('JWT_SECRET');
        $token = JWT::encode($payload, $key, 'HS256');

        return $this->respond(['token' => $token]);
    }
}