<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonPage;
use Illuminate\Http\Request;

class LessonPageController extends Controller
{
    // Get all pages for a lesson
    public function index($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        $pages = $lesson->pages()->orderBy('page_number')->get();

        return response()->json($pages);
    }

    // Get a specific page for a lesson
    public function showPage($lessonId, $pageNumber)
    {
        $page = LessonPage::where('lesson_id', $lessonId)
            ->where('page_number', $pageNumber)
            ->first();

        if (!$page) {
            return response()->json(['message' => 'Page not found.'], 404);
        }

        return response()->json($page);
    }
}
