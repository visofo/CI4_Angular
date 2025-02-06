<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getServer('HTTP_AUTHORIZATION');
        if (!$authHeader) {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'Token ausente');
        }
        // Geralmente o header vem como "Bearer token"
        $arr = explode(" ", $authHeader);
        //$token = $arr[1] ?? null;
        $token = isset($arr[1]) ? $arr[1] : null;
        if (!$token) {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'Token inválido');
        }
        try {
            $key = getenv('jwt.secret');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            // Você pode colocar os dados decodificados no request para uso posterior
            $request->decoded = $decoded;
        } catch (\Exception $e) {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, $e->getMessage());
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Sem ação após a execução
    }
}
