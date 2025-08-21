<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class User extends ResourceController
{
    protected $format = 'json';
    private $key = 'chave_secreta_segura';

    public function profile()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return $this->failUnauthorized('Token ausente');
        }

        $token = str_replace('Bearer ', '', $authHeader);

        try {
            $decoded = JWT::decode($token, new Key($this->key, 'HS256'));
            return $this->respond([
                'status' => 'Token válido',
                'user' => [
                    'id' => $decoded->sub,
                    'email' => $decoded->email
                ]
            ]);
        } catch (\Exception $e) {
            return $this->failUnauthorized('Token inválido ou expirado');
        }
    }
}
