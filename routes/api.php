<?php

// use App\Http\Controllers\PostController;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CustomerController;

// Route::get('/posts', [PostController::class, 'index']);  // Get all posts
// Route::get('/posts/{id}', [PostController::class, 'show']); // Get a single post
// Route::post('/posts', [PostController::class, 'store']); // Create a post
// Route::put('/posts/{id}', [PostController::class, 'update']); // Update a post
// Route::delete('/posts/{id}', [PostController::class, 'destroy']); // Delete a post

Route::prefix('/v1')->group(function () {
    Route::apiResource('customers', CustomerController::class);
});

use Illuminate\Support\Facades\Route;

Route::get('/apitest', function () {
    return response()->json(['message' => 'This is working!']);
});

// // in routes/api.php
// Route::post('/login', [AuthController::class, 'login']);
