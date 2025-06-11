<?php

namespace Tests\App\Controllers\Api\V1;

use App\Models\TodoModel;
use CodeIgniter\Test\Fabricator;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

final class TodosTest extends CIUnitTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
        // Optional: helper('filter_helper');
        $this->model = new TodoModel();
        $this->model->truncate();
    }

    /**
     * Test to show all todos (GET)
     */
    public function testShowTodos()
    {
        // Insert a test todo
        $todo = [
            'title'       => 'Test Todo',
            'description' => 'Test Desc',
            'category_id' => 1,
            'status'      => 1,
            'due_date'    => '2025-01-01',
        ];
        $this->model->insert($todo);

        // Call the controller's index method
        $result = $this->controller(\App\Controllers\Api\V1\Todos::class)->execute('index');

        $this->assertTrue($result->isOK());

        $response = $result->response();
        $this->assertJson($response->getBody());

        $response_array = json_decode($response->getBody(), true);

        // Check if at least one todo is present and has correct title
        $this->assertNotEmpty($response_array);
        $this->assertEquals('Test Todo', $response_array[0]['title']);
    }

    /**
     * Test to add a todo (POST)
     */
    public function testAddTodo()
    {
        // Use Fabricator for fake data if you want, or just use an array
        $payload = [
            'title'       => 'Fabricated Todo',
            'description' => 'Created by test',
            'category_id' => 2,
            'status'      => 1,
            'due_date'    => '2025-12-31',
        ];

        $result = $this
            ->withBody(json_encode($payload))
            ->withHeader('Content-Type', 'application/json')
            ->controller(\App\Controllers\Api\V1\Todos::class)
            ->execute('create');

        // Check if new entry is correct in database
        $this->seeInDatabase('todos', [
            'title'       => $payload['title'],
            'category_id' => $payload['category_id'],
        ]);

        $response = $result->response();
        $this->assertJson($response->getBody());
    }
}