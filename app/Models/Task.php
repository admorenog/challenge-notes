<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use HasFactory;

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            TaskCategory::class
        );
    }

    public static function getWithCategories(): \Illuminate\Support\Collection
    {
        $tasksAndCategories = DB::table((new self())->getTable())
            ->join((new TaskCategory)->getTable(),'task_id', 'tasks.id')
            ->join((new Category)->getTable(),'category_id', 'categories.id')
            ->select([
                'tasks.*',
                DB::raw('categories.name as "category_name"'),
                DB::raw('categories.id as "category_id"'),
            ])->get();

            return self::groupCategoriesbyTasks($tasksAndCategories);
    }

    private static function groupCategoriesbyTasks($tasksAndCategories)
    {
        $groupedCategoriesByTask = $tasksAndCategories->groupBy('id');

        return $groupedCategoriesByTask->map(function($task) {
            return [
                "id" => $task->first()->id,
                "name" => $task->first()->name,
                "categories" => $task->pluck('category_name', 'category_id')
            ];
        });
    }
}
