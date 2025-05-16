<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\LessonController;
use App\Http\Controllers\Api\V1\LessonPageController;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\ModuleController;
use App\Http\Controllers\Api\V1\TestController;
use App\Http\Controllers\Api\V1\AdminController;
use Spatie\Permission\Models\Permission;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

Route::prefix('v1')->group(function () {

    Route::get('/pcourses', [CourseController::class, 'publicIndex']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::post('lessons/{lesson}/submit', [LessonController::class, 'submit']);
        Route::get('user-courses', function(Request $request) {
            return $request->user()->courses; 
        });
        Route::get('/courses', [CourseController::class, 'index']);
        Route::get('/courses/{id}', [CourseController::class, 'show']);
        Route::get('/courses/{courseId}/modules', [CourseController::class, 'getCourseModules']);
        Route::get('/modules/{moduleId}', [CourseController::class, 'showModule']);
        Route::get('/modules/{moduleId}/lessons', [CourseController::class, 'getLessons']);
        Route::get('/lessons/{lessonId}', [CourseController::class, 'showLesson']);
        Route::get('/lessons/{lessonId}/next', [CourseController::class, 'getNextLesson']);
        Route::get('/lessons/{lessonId}/previous', [CourseController::class, 'getPreviousLesson']);
        Route::get('/lessons/{lessonId}/pages', [LessonPageController::class, 'index']);
        Route::get('/lessons/{lessonId}/pages/{pageNumber}', [LessonPageController::class, 'showPage']);
        Route::get('/lessons/{lessonId}/pages/{pageNumber}/next', [LessonPageController::class, 'getNextPage']);
        Route::get('courses/{course}/tests', [TestController::class, 'index']);
        Route::get('courses/{course}/tests/{test}', [TestController::class, 'show']);
        Route::get('courses/{course}/tests/{test}/questions', [TestController::class, 'getQuestions']);
        Route::post('courses/{course}/status', [CourseController::class, 'updateStatus']);
        Route::get('user/completed-courses', [UserController::class, 'completedCoursesSummary']);

    });
});

Route::prefix('v1/admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('users/{user}/assign-role', [AdminController::class, 'assignRole']);
    Route::post('lesson-pages', [LessonPageController::class, 'store']);
    Route::post('seed-course', [SeederApiController::class, 'seedCourse']);
    Route::post('seed-module', [SeederApiController::class, 'seedModule']);
    Route::post('seed-lesson', [SeederApiController::class, 'seedLesson']);
    Route::post('seed-test', [SeederApiController::class, 'seedTest']);
    Route::get('courses', [CourseController::class, 'dropDownCourse']);
    Route::get('users/completed-courses', [UserController::class, 'allUsersCompletedCourses']);
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
        'user' => [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]
    ]);
});

Route::post('/login', function(Request $request) {
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $validated['email'])->first();

    if (!$user || !Hash::check($validated['password'], $user->password)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $token = $user->createToken('user-token', ['view-courses'])->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]
    ]);
});
