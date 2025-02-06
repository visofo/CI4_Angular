<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class AuthController extends ResourceController
{
    protected $format = 'json';

    public function login()
    {
        $model = new UserModel();

        // Receber os dados (usuário, senha) da requisição
        $data = $this->request->getJSON();
        $user = $model->where('email', $email)->first();

        // Validação simplificada
        // if ($data->username == 'admin' && $data->password == '123456') {
        //     // Gerar JWT
        //     $jwt = $this->generateJWT($data->username);
        //     return $this->respond(['token' => $jwt]);
        // }
        //return $this->failUnauthorized('Usuário ou senha incorretos.');

        if (!$user || !password_verify($data->password, $user['password'])) {
            return $this->failUnauthorized('Invalid credentials');
        }

        $key = getenv('jwt.secret');
        $payload = [
            'iat' => time(),
            'exp' => time() + 3600,
            'uid' => $user['id'],
        ];

        $token = JWT::encode($payload, $key, 'HS256');
        return $this->respond(['token' => $token]);
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

    public function register()
    {
        $model = new UserModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];

        $model->save($data);

        return $this->respondCreated($data);
    }
}
