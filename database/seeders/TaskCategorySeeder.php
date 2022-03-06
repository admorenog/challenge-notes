<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::factory(3)->create();

        $tasks = Task::factory(3)->create();

        foreach($tasks as $task) {
            $task->categories()->sync($categories);
        }

    }
}
