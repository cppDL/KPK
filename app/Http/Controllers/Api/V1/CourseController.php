<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CourseController extends Controller
{
    // Cache duration in minutes
    const CACHE_DURATION = 60;

    /**
     * Get paginated courses with modules
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);

        $cacheKey = "courses.page_{$page}.per_page_{$perPage}";

        $courses = Cache::remember($cacheKey, now()->addMinutes(self::CACHE_DURATION), function() use ($perPage) {
            return Course::with(['modules' => function($query) {
                        $query->orderBy('order');
                    }])
                    ->orderBy('created_at')
                    ->paginate($perPage);
        });

        return response()->json([
            'success' => true,
            'data' => $courses
        ]);
    }

    /**
     * Get single course with paginated modules
     */
    public function show($id, Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $cacheKey = "course.{$id}.per_page_{$perPage}";

        $course = Cache::remember($cacheKey, now()->addMinutes(self::CACHE_DURATION), function() use ($id, $perPage) {
            return Course::with(['modules' => function($query) use ($perPage) {
                        $query->orderBy('order')
                              ->with(['lessons', 'quizzes']);
                    }])
                    ->findOrFail($id);
        });

        return response()->json([
            'success' => true,
            'data' => $course
        ]);
    }

    /**
     * Get paginated modules for a course
     */
    public function getCourseModules($courseId, Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 5);
        $cacheKey = "course.{$courseId}.modules.page_{$page}";

        $modules = Cache::remember($cacheKey, now()->addMinutes(self::CACHE_DURATION), function() use ($courseId, $perPage) {
            return Module::where('course_id', $courseId)
                        ->with(['lessons', 'quizzes'])
                        ->orderBy('order')
                        ->paginate($perPage);
        });

        return response()->json([
            'success' => true,
            'data' => $modules
        ]);
    }
}