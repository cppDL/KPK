<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\LessonController;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\ModuleController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);
    Route::get('/courses/{courseId}/modules', [CourseController::class, 'getCourseModules']);
    Route::get('/modules/{moduleId}/lessons', [CourseController::class, 'getLessons']);
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::post('lessons/{lesson}/submit', [LessonController::class, 'submit']);
        Route::get('user-courses', function(Request $request) {
            return $request->user()->courses; 
        });
    });
});

Route::post('/generate-user-token', function(Request $request) {
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'password' => 'required|string'
    ]);
    
    $user = User::firstOrCreate(
        ['email' => $validated['email']],
        [
            'name' => $validated['name'],
            'password' => Hash::make($validated['password'])
        ]
    );

    $token = $user->createToken('user-token', ['view-courses'])->plainTextToken;

    return response()->json([
        'token' => $token,
        'user_id' => $user->id
    ]);
});