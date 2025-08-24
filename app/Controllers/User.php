<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class User extends ResourceController {
    protected $format = 'json';

    public function profile() {
        $user = $this->request->user ?? null;

        if (!$user) {
            return $this->failUnauthorized('Usuário não autenticado');
        }

        return $this->respond([
            'status' => 'Usuário autenticado',
            'user' => [
                'id' => $user->sub,
                'email' => $user->email,
            ],
        ]);
    }
}
