<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
{
    $header = $request->getHeaderLine('Authorization');

    if (!$header) {
        return service('response')
            ->setStatusCode(401)
            ->setJSON(['error' => 'Token não fornecido']);
    }

    if (!preg_match('/Bearer\s(\S+)/', $header, $matches)) {
        return service('response')
            ->setStatusCode(401)
            ->setJSON(['error' => 'Token mal formatado']);
    }

    $token = $matches[1];

    try {
        $key = getenv('JWT_SECRET');
        $decoded = JWT::decode($token, new Key($key, 'HS256'));

        // **INJETAR no request para o controller usar:**
        $request->user = $decoded;

    } catch (\Exception $e) {
        return service('response')
            ->setStatusCode(401)
            ->setJSON(['error' => 'Token inválido ou expirado']);
    }

    return null;
}


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Não necessário aqui
    }
}
