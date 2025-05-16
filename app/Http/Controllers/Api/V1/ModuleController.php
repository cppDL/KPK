<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index(Course $course)
    {
        return Module::where('course_id', $courseId)->get();
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'xp_reward' => 'integer|min:0'
        ]);

        $module = $course->modules()->create([
            'title' => $validated['title'],
            'xp_reward' => $validated['xp_reward'] ?? 10,
            'order' => $course->modules()->count() + 1
        ]);

        return response()->json([
            'data' => $module
        ], 201);
    }

    public function show(Module $module)
    {
        return response()->json([
            'data' => $module->load('lessons')
        ]);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function seedModule(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string',
        ]);
        $module = Module::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
        ]);

        return response()->json(['message' => 'Module created', 'module' => $module]);
    }
}
