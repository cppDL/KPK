<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Your lesson listing logic
    }

    // Submit lesson answer
    public function submit(Request $request, Lesson $lesson)
    {
        $request->validate([
            'answer' => 'required|string'
        ]);

        $user = auth()->user();
        $isCorrect = $this->checkSolution($lesson, $request->answer);

        // Update or create progress
        UserProgress::updateOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $lesson->id],
            ['xp_earned' => $isCorrect ? $lesson->module->xp_reward : 0]
        );

        return response()->json([
            'correct' => $isCorrect,
            'xp_earned' => $isCorrect ? $lesson->module->xp_reward : 0
        ]);
    }

    private function checkSolution(Lesson $lesson, $userAnswer): bool
    {
        // Simple code comparison (adjust for quizzes/theory)
        if ($lesson->type === 'code') {
            return trim($userAnswer) === trim($lesson->solution['code']);
        }
        return false;
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

    public function seedLesson(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'title' => 'required|string',
        ]);
        $lesson = Lesson::create([
            'module_id' => $request->module_id,
            'title' => $request->title,
        ]);

        return response()->json(['message' => 'Lesson created', 'lesson' => $lesson]);
    }
    
}
