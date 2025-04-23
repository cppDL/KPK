<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        return Module::where('course_id', $courseId)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        return response()->json([
            'data' => $module->load('lessons') // Eager load lessons
        ]);
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
