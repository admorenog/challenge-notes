<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('tasks', TaskController::class)->only(['index', 'store', 'destroy']);
Route::resource('categories', CategoryController::class)->only(['index']);
