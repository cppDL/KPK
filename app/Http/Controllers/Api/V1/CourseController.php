<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource (all courses).
     */
    public function index(Request $request)
    {
        // Validate query parameters
        $validator = Validator::make($request->all(), [
            'page' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $page = $request->query('page', 1);
        $perPage = 10;

        // Cache key is unique to the page number
        $cacheKey = "courses_page_{$page}";

        $courses = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($perPage) {
            return Course::paginate($perPage);
        });

        return response()->json($courses);
    }

    /**
     * Display the specified course.
     */
    public function show($id)
    {
        $course = Course::findOrFail($id);  // Find the course by ID or fail if not found
        return response()->json($course);
    }

    /**
     * Display the modules of a specific course.
     */
    public function getCourseModules(Request $request, $courseId)
    {
        // Validate query parameters
        $validator = Validator::make($request->all(), [
            'page' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $page = $request->query('page', 1);
        $perPage = 10;

        // Cache key for the course and page
        $cacheKey = "course_{$courseId}_modules_page_{$page}";

        $course = Course::findOrFail($courseId);

        $modules = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($course, $perPage) {
            return $course->modules()->paginate($perPage);
        });

        return response()->json($modules);
    }

    /**
     * Display a specific module by its ID.
     */
    public function showModule($moduleId)
    {
        $module = Module::findOrFail($moduleId);  // Find the module by ID or fail if not found
        return response()->json($module);
    }

    /**
     * Display the lessons of a specific module.
     */
    public function getLessons(Request $request, $moduleId)
    {
        // Validate query parameters
        $validator = Validator::make($request->all(), [
            'page' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $page = $request->query('page', 1);
        $perPage = 10;

        // Cache key for the module and page
        $cacheKey = "module_{$moduleId}_lessons_page_{$page}";

        $module = Module::findOrFail($moduleId);

        $lessons = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($module, $perPage) {
            return $module->lessons()->paginate($perPage);
        });

        return response()->json($lessons);
    }

    /**
     * Display a specific lesson by its ID.
     */
    public function showLesson($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);  // Find the lesson by ID or fail if not found
        return response()->json($lesson);
    }
}
