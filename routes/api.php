<?php

// use App\Http\Controllers\PostController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\LessonController;
use App\Http\Controllers\Api\V1\CourseController;
// Route::get('/posts', [PostController::class, 'index']);  // Get all posts
// Route::get('/posts/{id}', [PostController::class, 'show']); // Get a single post
// Route::post('/posts', [PostController::class, 'store']); // Create a post
// Route::put('/posts/{id}', [PostController::class, 'update']); // Update a post
// Route::delete('/posts/{id}', [PostController::class, 'destroy']); // Delete a post


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'auth:sanctum'], function() {
    Route::apiResource('customers', CustomerController::class);
});

// use Illuminate\Support\Facades\Route;

Route::get('/apitest', function () {
    return response()->json(['message' => 'This is working!']);
});

// // in routes/api.php
// Route::post('/login', [AuthController::class, 'login']);


// Public endpoints
Route::get('/courses', [CourseController::class, 'index']);

Route::get('/courses/{course}/modules', [ModuleController::class, 'index']);
Route::get('/modules/{module}', [ModuleController::class, 'show']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/courses/{course}/modules', [ModuleController::class, 'store']);
});

// Protected endpoints (require auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/modules/{module}/lessons', [LessonController::class, 'index']);
    Route::post('/lessons/{lesson}/submit', [LessonController::class, 'submit']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/lessons/{lesson}/submit', [LessonController::class, 'submit']);
});