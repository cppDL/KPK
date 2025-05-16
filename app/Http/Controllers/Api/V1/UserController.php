<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreUserRequest;
use App\Http\Requests\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Http\Resources\V1\UserCollection;
use Illuminate\Http\Request;  

class UserController extends Controller
{
    public function index()
    {
        return new UserCollection(User::all());
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }

    public function completedCoursesSummary(Request $request)
    {
        $user = $request->user();

        $courses = $user->completedCourses()->get()->map(function ($course) {
            $completedAt = $course->pivot->completed_at;
            return [
                'title'        => $course->title,
                'completed_at' => $completedAt,
                'is_outdated'  => $completedAt 
                                ? now()->diffInDays($completedAt) > 365 
                                : false,
            ];
        });

        return response()->json([
            'user'    => $user->name,
            'courses' => $courses,
        ]);
    }

    public function allUsersCompletedCourses(Request $request)
    {
        $users = User::with(['completedCourses' => function($q){
            $q->select('courses.id','title','course_user.completed_at');
        }])->get();

        $payload = $users->map(function($user){
            return [
                'user_id' => $user->id,
                'name'    => $user->name,
                'completed_courses' => $user->completedCourses->map(function($course){
                    $completedAt = $course->pivot->completed_at;
                    return [
                        'course_id'    => $course->id,
                        'title'        => $course->title,
                        'completed_at' => $completedAt,
                        'is_outdated'  => $completedAt 
                                          ? now()->diffInDays($completedAt) > 365 
                                          : false,
                    ];
                }),
            ];
        });

        return response()->json($payload);
    }
}
