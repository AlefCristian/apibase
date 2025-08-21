<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth extends ResourceController
{
    protected $format = 'json';
    private $key = 'chave_secreta_segura'; // 🔒 Altere para algo mais seguro

    public function register()
    {
        $rules = [
            'username' => 'required',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $model = new UserModel();

        $data = [
            'username' => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];

        $model->save($data);
        return $this->respondCreated(['message' => 'Usuário registrado com sucesso']);
    }

    public function login()
    {
        $model = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $model->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Email ou senha inválidos.');
        }

        $payload = [
            'sub' => $user['id'],
            'email' => $user['email'],
            'iat' => time(),
            'exp' => time() + 3600 // 1 hora
        ];

        $token = JWT::encode($payload, $this->key, 'HS256');

        return $this->respond(['token' => $token]);
    }
}
