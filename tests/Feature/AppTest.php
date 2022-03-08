<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppTest extends TestCase
{
    /**
     * Tests that the web responds
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /**
     * Tests that the api returns the resources
     *
     * @return void
     */
    public function test_the_api_returns_an_array()
    {
        $response = $this->get('/api/tasks');

        $response->assertStatus(200);
    }

    /**
     * Tests that the api create the resource
     *
     * @return void
     */
    public function test_the_api_create_the_resource()
    {
        $params = [
            'name' => 'probando una tarea con unas categorías',
            'categories' => Category::pluck('id')->toArray()
        ];
        $response = $this->post('/api/tasks/', $params);
        $response->assertStatus(201);
        $task = Task::where('name', $params['name'])->with('categories')->first();
        $this->assertNotNull($task);

        $this->assertCount(count($params['categories']), $task->categories);
    }

    /**
     * Tests that the api delete the resource
     *
     * @return void
     */
    public function test_the_api_removes_the_resource()
    {
        $task = Task::where('name', 'probando una tarea con unas categorías')->first();
        $this->delete('/api/tasks/' . $task->id);
        $task = Task::find($task->id);
        $this->assertNull($task);
    }
}
