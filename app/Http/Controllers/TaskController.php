<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response
     */
    public function index() : JsonResponse|Response
    {
        /**
         * The document specifications requires a "just one sql to get tasks and categories" and the eager loading
         * relationship doesn't fit because it throws 2 SQL:
         *
         * return response()->json(Task::with('categories')->get());
         * select * from tasks;
         * select * from categories where id in (x,x,x,x)
         *
         * So I used a custom model static method that uses one sql (with query builder) and reformat the information.
         * I use this kind of process when we need an optimization over a big bunch of records. When the memory is a
         * problem we also can use a chunk system to "paginate" the information.
         */
        return response()->json(Task::getWithCategories());
    }

    /**
     * Store a newly created Task in storage.
     *
     * @param StoreTaskRequest $request
     * @return Response
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create([
            'name' => $request->name
        ]);

        $categories = Category::whereIn('id', $request->categories)->get();

        $task->categories()->attach($categories);
        $task->load('categories');

        return response()->json($task, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(Task::getWithCategories());
    }
}
