<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

// class CourseController extends Controller
// {
//     // Show all courses with pagination, eager loading, and caching
//     public function index(Request $request)
//     {
//         $cacheKey = 'courses_page_' . $request->page;

//         // Attempt to get cached courses, if not found, query the database
//         $courses = Cache::remember($cacheKey, now()->addMinutes(10), function () {
//             return Course::with(['modules.lessons']) // Eager loading modules and lessons
//                 ->paginate(10); // Paginate the results, 10 per page
//         });

//         return response()->json($courses);
//     }

//     // Show a single course by ID with related modules and lessons
//     public function show($id)
//     {
//         $course = Course::with(['modules.lessons'])->findOrFail($id);

//         return response()->json($course);
//     }

//     // Show the modules for a specific course with lessons
//     public function getModules($courseId)
//     {
//         $course = Course::findOrFail($courseId);

//         // Get the modules for this course, with related lessons
//         $modules = $course->modules()->with('lessons')->get();

//         return response()->json($modules);
//     }

//     // Show the lessons for a specific module
//     public function getLessons($moduleId)
//     {
//         $module = Module::findOrFail($moduleId);

//         // Get the lessons for this module
//         $lessons = $module->lessons()->get();

//         return response()->json($lessons);
//     }
// }
