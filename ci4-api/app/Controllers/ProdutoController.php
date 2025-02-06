<?php

namespace App\Controllers\Api;

use App\Models\ProdutoModel;
use CodeIgniter\RESTful\ResourceController;

class ProdutoController extends ResourceController
{
    protected $modelName = 'App\Models\ProdutoModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function create()
    {
        $data = $this->request->getJSON();
        if ($this->model->insert($data)) {
            $response = [
                'status'   => 201,
                'error'    => null,
                'messages' => [
                    'success' => 'Produto criado com sucesso'
                ]
            ];
            return $this->respondCreated($response);
        } else {
            return $this->fail($this->model->errors());
        }
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Nenhum produto encontrado com o id ' . $id);
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON();
        if ($this->model->update($id, $data)) {
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Produto atualizado com sucesso'
                ]
            ];
            return $this->respond($response);
        } else {
            return $this->fail($this->model->errors());
        }
    }

    public function delete($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            $this->model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Produto deletado com sucesso'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Nenhum produto encontrado com o id ' . $id);
        }
    }
}