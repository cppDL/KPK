<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $page = $request->query('page', 1);
        $perPage = 10;

        $cacheKey = "courses_page_{$page}";

        $courses = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($perPage) {
            return Course::paginate($perPage);
        });

        return response()->json($courses);
    }

    public function publicIndex(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $page = $request->query('page', 1);
        $perPage = 10;

        $cacheKey = "public_courses_page_{$page}";

        $courses = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($perPage) {
            return Course::select('id', 'title', 'description')->paginate($perPage);
        });

        return response()->json($courses);
    }

    public function show(Request $request, $id)
    {
        $course = Course::with('modules.lessons')->findOrFail($id);

        $userStatus = null;
        if ($request->user()) {
            $pivot = $request->user()
                            ->completedCourses()
                            ->where('course_id', $course->id)
                            ->first()?->pivot;

            if ($pivot) {
                $userStatus = [
                    'status'       => $pivot->status,
                    'completed_at' => $pivot->completed_at,
                    'expired'      => $pivot->completed_at
                                    ? now()->diffInDays($pivot->completed_at) > 365
                                    : false,
                ];
            }
        }

        return response()->json([
            'course'      => $course,
            'user_status' => $userStatus,
        ]);
    }


    public function getCourseModules(Request $request, $courseId)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $page = $request->query('page', 1);
        $perPage = 10;

        $cacheKey = "course_{$courseId}_modules_page_{$page}";

        $course = Course::findOrFail($courseId);

        $modules = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($course, $perPage) {
            return $course->modules()->paginate($perPage);
        });

        return response()->json($modules);
    }

    public function showModule($moduleId)
    {
        $module = Module::findOrFail($moduleId);
        return response()->json($module);
    }

    public function getLessons(Request $request, $moduleId)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $page = $request->query('page', 1);
        $perPage = 10;

        $cacheKey = "module_{$moduleId}_lessons_page_{$page}";

        $module = Module::findOrFail($moduleId);

        $lessons = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($module, $perPage) {
            return $module->lessons()->paginate($perPage);
        });

        return response()->json($lessons);
    }

public function getNextLesson($lessonId)
    {
        $currentLesson = Lesson::findOrFail($lessonId);
        $nextLesson = Lesson::where('module_id', $currentLesson->module_id)
            ->where('order', '>', $currentLesson->order)
            ->orderBy('order', 'asc')
            ->first();

        return $nextLesson ?? response()->json(['message' => 'No next lesson.'], 404);
    }

public function getPreviousLesson($lessonId)
    {
        $currentLesson = Lesson::findOrFail($lessonId);
        $prevLesson = Lesson::where('module_id', $currentLesson->module_id)
            ->where('order', '<', $currentLesson->order)
            ->orderBy('order', 'desc')
            ->first();

        return $prevLesson ?? response()->json(['message' => 'No previous lesson.'], 404);
    }

    public function showLesson($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        return response()->json($lesson);
    }

    public function seedCourse(Request $request)
    {
        $request->validate([
            'slug' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);
        $course = Course::create(['title' => $request->title]);

        return response()->json(['message' => 'Course created', 'course' => $course]);
    }

    public function updateStatus(Request $request, Course $course)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in([
                Course::STATUS_AVAILABLE,
                Course::STATUS_IN_PROGRESS,
                Course::STATUS_COMPLETED,
            ])],
        ]);

        $user = $request->user();

        $pivotData = ['status' => $data['status']];

        if ($data['status'] === Course::STATUS_COMPLETED) {
            $pivotData['completed_at'] = now();
        }

        $user->completedCourses()->syncWithoutDetaching([
            $course->id => $pivotData
        ]);

        return response()->json([
            'course_id'    => $course->id,
            'status'       => $pivotData['status'],
            'completed_at' => $pivotData['completed_at'] ?? null,
        ]);
    }

}
