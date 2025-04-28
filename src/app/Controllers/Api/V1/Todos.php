<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class Todos extends ResourceController
{
    protected $modelName = 'App\Models\TodoModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }
}
