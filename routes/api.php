<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\LessonController;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\ModuleController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'auth:sanctum'], function() {
//     Route::apiResource('customers', CustomerController::class);
// });

// // use Illuminate\Support\Facades\Route;

// Route::get('/apitest', function () {
//     return response()->json(['message' => 'This is working!']);
// });

// // // in routes/api.php
// // Route::post('/login', [AuthController::class, 'login']);


// // Public endpoints
// Route::get('/courses', [CourseController::class, 'index']);

// Route::get('/courses/{course}/modules', [ModuleController::class, 'index']);
// Route::get('/modules/{module}', [ModuleController::class, 'show']);

// Route::middleware(['auth:sanctum', 'admin'])->group(function () {
//     Route::post('/courses/{course}/modules', [ModuleController::class, 'store']);
// });

// // Protected endpoints (require auth)
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/modules/{module}/lessons', [LessonController::class, 'index']);
//     Route::post('/lessons/{lesson}/submit', [LessonController::class, 'submit']);
// });

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/lessons/{lesson}/submit', [LessonController::class, 'submit']);
// });



// // Test route (keep this exactly as you had it)
// Route::get('/apitest', function () {
//     return response()->json(['message' => 'This is working!']);
// });

// // Your working customer route (unchanged)
// Route::group([
//     'prefix' => 'v1',
//     'namespace' => 'App\Http\Controllers\Api\V1',
//     'auth:sanctum'
// ], function() {
//     Route::apiResource('customers', CustomerController::class);
// });

// // Your course routes (exactly as you had them)
// Route::get('/courses', [CourseController::class, 'index']);
// Route::get('/courses/{course}/modules', [ModuleController::class, 'index']); 
// Route::get('/modules/{module}', [ModuleController::class, 'show']);

// // Your protected routes (exactly as you had them)
// Route::middleware(['auth:sanctum', 'admin'])->group(function () {
//     Route::post('/courses/{course}/modules', [ModuleController::class, 'store']);
// });

// // Your lesson routes (exactly as you had them)
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/modules/{module}/lessons', [LessonController::class, 'index']);
//     Route::post('/lessons/{lesson}/submit', [LessonController::class, 'submit']);
// });

// // Your user route (exactly as you had it)
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });




Route::prefix('v1')->group(function () {
    // Public routes
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{course}/modules', [ModuleController::class, 'index']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('customers', CustomerController::class);
        Route::post('/lessons/{lesson}/submit', [LessonController::class, 'submit']);
    });
});
