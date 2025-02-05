<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class AuthController extends ResourceController
{
    protected $format = 'json';

    public function login()
    {
        // Receber os dados (usuário, senha) da requisição
        $data = $this->request->getJSON();

        // Validação simplificada
        if ($data->username == 'admin' && $data->password == '123456') {
            // Gerar JWT
            $jwt = $this->generateJWT($data->username);
            return $this->respond(['token' => $jwt]);
        }
        return $this->failUnauthorized('Usuário ou senha incorretos.');
    }

    private function generateJWT($username)
    {
        // Utilize uma biblioteca JWT, como firebase/php-jwt
        // Instale: composer require firebase/php-jwt

        $key = getenv('jwt.secret'); // Configure no .env
        $payload = [
            'iss'  => base_url(),
            'aud'  => base_url(),
            'iat'  => time(),
            'nbf'  => time(),
            'exp'  => time() + 3600, // token válido por 1 hora
            'data' => ['username' => $username]
        ];
        return \Firebase\JWT\JWT::encode($payload, $key, 'HS256');
    }
}
