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

    // public function allUsersCompletedCourses(Request $request)
    // {
    //     $users = User::with(['completedCourses' => function($q){
    //         $q->select('courses.id','title','course_user.completed_at');
    //     }])->get();

    //     $payload = $users->map(function($user){
    //         return [
    //             'user_id' => $user->id,
    //             'name'    => $user->name,
    //             'completed_courses' => $user->completedCourses->map(function($course){
    //                 $completedAt = $course->pivot->completed_at;
    //                 return [
    //                     'course_id'    => $course->id,
    //                     'title'        => $course->title,
    //                     'completed_at' => $completedAt,
    //                     'is_outdated'  => $completedAt 
    //                                       ? now()->diffInDays($completedAt) > 365 
    //                                       : false,
    //                 ];
    //             }),
    //         ];
    //     });

    //     return response()->json($payload);
    // }

    public function allUsersCompletedCourses(Request $request)
    {
        $users = User::with([
            'completedCourses.modules' => function($q) {
                $q->select('modules.id','modules.course_id');
            },
            'testAttempts'
        ])->get();

        $payload = $users->map(function($user) {
            $completedCourses = $user->completedCourses;

            $totalCompleted       = $completedCourses->count();
            $averageCompletion    = $completedCourses->avg(fn($c) => $c->pivot->percentage ?? 0);
            $daysSinceLastFinish  = $completedCourses->max(fn($c) => now()->diffInDays($c->pivot->completed_at));

            $latestAttempt = $user->testAttempts->first();

            return [
                'user_id'                 => $user->id,
                'name'                    => $user->name,
                'last_login_at'           => $user->last_login_at ?? $user->updated_at,
                'latest_test_score'       => $latestAttempt?->score,
                'latest_test_date'        => $latestAttempt?->created_at,
                'total_completed'         => $totalCompleted,
                'average_completion_pct'  => round($averageCompletion, 2),
                'days_since_last_finish'  => $daysSinceLastFinish,

                'completed_courses' => $completedCourses->map(function($course) use ($user) {
                    $pivot   = $course->pivot;
                    $started = $pivot->created_at;
                    $ended   = $pivot->completed_at;

                    return [
                        'course_id'          => $course->id,
                        'title'              => $course->title,
                        'completed_at'       => $ended,
                        'percentage'         => $pivot->percentage,
                        'days_since'         => $ended ? now()->diffInDays($ended) : null,
                        'time_spent_days'    => $ended ? now()->diffInDays($started, $ended) : null,
                        'module_count'       => $course->modules->count(),
                    ];
                }),
            ];
        });

        return response()->json($payload);
    }
}