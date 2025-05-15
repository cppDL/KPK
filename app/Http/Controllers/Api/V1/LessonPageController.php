<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Lesson;
use App\Models\LessonPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function getNextPage($lessonId, $pageNumber)
    {
        $nextPageNumber = $pageNumber + 1;

        $nextPage = LessonPage::where('lesson_id', $lessonId)
                            ->where('page_number', $nextPageNumber)
                            ->first();

        if (!$nextPage) {
            return response()->json(['message' => 'No next page.'], 404);
        }

        return response()->json($nextPage);
    }
    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'content' => 'required|string',
            'image' => 'nullable|url',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('lesson_images', 'public');
        }

        $pageNumber = LessonPage::where('lesson_id', $request->lesson_id)->max('page_number') + 1;

        $page = LessonPage::create([
            'lesson_id' => $request->lesson_id,
            'page_number' => $pageNumber,
            'content' => $request->content,
            'image_url' => $request->image_url,
        ]);

        return response()->json($page, 201);
    }


}
