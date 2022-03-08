<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Task;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * Tests the tasks in the method that retrieves all tasks with categories using only one sql
     *
     * @return void
     */
    public function test_one_sql_method_tasks()
    {
        $tasksWithEloquent = Task::with('categories')->get();

        $tasks = Task::getWithCategories();

        foreach($tasks as $task) {
            $this->assertNotNull($tasksWithEloquent->where('id', $task["id"]));
        }
    }

    /**
     * Tests the categories in the method that retrieves all tasks with categories using only one sql
     *
     * @return void
     */
    public function test_one_sql_method_categories()
    {
        $tasksWithEloquent = Task::with('categories')->get();

        $tasks = Task::getWithCategories();

        foreach($tasks as $task) {
            $taskWithEloquent = $tasksWithEloquent->where('id', $task["id"])->first();
            $categories = $taskWithEloquent->categories;
            $this->assertCount(
                $categories->count(),
                $task['categories']
            );
            foreach($task['categories'] as $category) {
                $this->assertNotNull($categories->where('id', $category['id']));
            }
        }
    }

    private function createTasksAndCategories() {
        $categories = Category::factory(3)->create();

        $tasks = Task::factory(3)->create();

        $countOfRandomCategories = 0;

        foreach($tasks as $task) {
            $randomCategories = $categories->random($countOfRandomCategories++);
            $task->categories()->sync($randomCategories);
        }

        return $tasks;
    }
}
