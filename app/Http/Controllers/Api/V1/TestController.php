<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index($courseId, Request $request)
    {
        $course = Course::findOrFail($courseId);

        $perPage = $request->query('per_page', 10);

        $tests = $course->tests()->paginate($perPage);

        return response()->json($tests);
    }

    public function show($courseId, $testId)
    {
        $test = Test::where('course_id', $courseId)->findOrFail($testId);

        return response()->json($test);
    }

    public function getQuestions($testId)
    {
        $test = Test::with('questions')->findOrFail($testId);

        return response()->json($test->questions);
    }

    public function seedTest(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string',
        ]);
        $test = Test::create([
            'lesson_id' => $request->lesson_id,
            'title' => $request->title,
        ]);

        return response()->json(['message' => 'Test created', 'test' => $test]);
    }
    

}
