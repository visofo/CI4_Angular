<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Test extends ResourceController
{
    public function index()
    {
        $data = [
            'message' => 'Hello from CodeIgniter 4 API!'
        ];
        return $this->respond($data);
    }
}