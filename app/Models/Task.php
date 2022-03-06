<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
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

    /**
     * Returns the tasks with categories using only one query to database.
     */
    public static function getWithCategories(): Collection
    {
        $tasksAndCategories = DB::table((new self())->getTable())
            ->leftJoin((new TaskCategory)->getTable(),'task_id', 'tasks.id')
            ->leftJoin((new Category)->getTable(),'category_id', 'categories.id')
            ->select([
                'tasks.*',
                DB::raw('categories.name as "category_name"'),
                DB::raw('categories.id as "category_id"'),
            ])->get();

            return self::groupCategoriesbyTasks($tasksAndCategories);
    }

    /**
     * Groups categories inside a task when the tasks are spreaded because there is a sql that joins n-n tables
     * and cleans the lower level structure.
     */
    private static function groupCategoriesbyTasks(Collection $tasksAndCategoriesSpreaded) : Collection
    {
        $groupedCategoriesByTask = $tasksAndCategoriesSpreaded->groupBy('id');

        $groupedCategoriesByTask = $groupedCategoriesByTask->map(function($spreadedTask) {
            $task = $spreadedTask->first();
            return collect([
                "id" => $task->id,
                "name" => $task->name,
                "categories" => Category::getCleanedCategories($spreadedTask)
            ]);
        });

        return $groupedCategoriesByTask->values();
    }
}
