<?php

namespace Tests\App\Controllers\Api\V1;

use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\CIUnitTestCase;
use App\Models\TodoModel;

final class TodosTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new TodoModel();
        $this->model->truncate();
    }

    public function testGetTodosReturnsInsertedTodo()
    {
        $todo = [
            'title'       => 'Test Todo',
            'description' => 'Test Desc',
            'category_id' => 1,
            'status'      => 'open',
            'due_date'    => '2024-12-31',
        ];
        $todo['tID'] = $this->model->insert($todo, true);

        $response = $this->call('get', '/api/v1/todos');
        $response->assertStatus(200);

        $todos = json_decode($response->getBody(), true);
        $this->assertIsArray($todos);
        $found = false;
        foreach ($todos as $item) {
            if ($item['tID'] == $todo['tID']) {
                $found = true;
                $this->assertEquals($todo['title'], $item['title']);
                $this->assertEquals($todo['status'], $item['status']);
            }
        }
        $this->assertTrue($found, 'Inserted todo not found in GET /todos');
    }

    public function testPostTodoCreatesTodo()
    {
        $payload = [
            'title'       => 'New Todo',
            'description' => 'New Desc',
            'category_id' => 2,
            'status'      => 'open',
            'due_date'    => '2025-01-01',
        ];

        $response = $this->call('post', '/api/v1/todos', $payload);
        $response->assertStatus(201);

        $todo = $this->model->where('title', $payload['title'])->first();
        $this->assertNotNull($todo);
        $this->assertEquals($payload['description'], $todo['description']);
    }
}