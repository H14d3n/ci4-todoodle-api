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
        // Get Query-Parameters
        $limit      = $this->request->getGet('limit');
        $offset     = $this->request->getGet('offset');
        $title      = $this->request->getGet('title'); // Filter by title
        $id         = $this->request->getGet('id');    // Filter by id
        $tID        = $this->request->getGet('tID'); // Filter by tID
        $categoryId = $this->request->getGet('category_id'); // Filter by category_id
        $status     = $this->request->getGet('status'); // Filter by status
        $order_by   = $this->request->getGet('order_by'); // z.B. "due_date,asc"

        $builder = $this->model;

        // Filter by title
        if ($title !== null) {
            $builder = $builder->like('title', $title);
        }

        // Filter by id or tID
        if ($id !== null) {
            $builder = $builder->where('tID', (int)$id);
        } elseif ($tID !== null) {
            $builder = $builder->where('tID', (int)$tID);
        }

        // Filter by category_id
        if ($categoryId !== null) {
            $builder = $builder->where('category_id', (int)$categoryId);
        }

        // Filter by status
        if ($status !== null) {
            $builder = $builder->where('status', $status);
        }

        // Sorting with whitelist
        $allowedOrderFields = ['id', 'title', 'due_date', 'category_id', 'created_at'];
        // Mapping for allowed fields (API → DB)
        $orderFieldMap = [
            'id'          => 'tID',         // API-Parameter "id" => "tID"
            'tID'         => 'tID',
            'title'       => 'title',
            'due_date'    => 'due_date',
            'category_id' => 'category_id',
            'created_at'  => 'created_at',
        ];

        // Apply ordering to the query if $order_by is set (e.g. "title,desc")
        if ($order_by !== null) {
            $parts = explode(',', $order_by);
            $field = $parts[0] ?? 'tID';
            $direction = strtolower($parts[1] ?? 'asc');
            if (!in_array($direction, ['asc', 'desc'])) {
                $direction = 'asc';
            }
            if (isset($orderFieldMap[$field])) {
                $builder = $builder->orderBy($orderFieldMap[$field], $direction);
            }
        }

        // Pagination
        if ($limit !== null) {
            if ((int)$limit === 0) {
                return $this->failValidationErrors(['limit' => 'Limit must be greater than 0.']);
            }
            $builder = $builder->limit((int)$limit);
        }
        if ($offset !== null) {
            $builder = $builder->offset((int)$offset);
        }

        $todos = $builder->findAll();

        return $this->respond($todos);
    }

    public function show($id = null)
    {
        $todo = $this->model->find($id);
        if ($todo) {
            return $this->respond($todo);
        } else {
            return $this->failNotFound('Todo with given id not found');
        }
    }

    public function create()
    {
        $data = $this->request->getJSON(true) ?? $this->request->getPost();
        if ($this->model->insert($data)) {
            return $this->respondCreated($data);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function update($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->failNotFound('Todo not found');
        }
        $data = $this->request->getJSON(true) ?? $this->request->getRawInput();
        unset($data['tID']);
        if ($this->model->update($id, $data)) {
            return $this->respondUpdated($data);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->failNotFound('Todo not found');
        }
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        } else {
            return $this->failServerError('Failed to delete Todo');
        }
    }
}
