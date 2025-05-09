<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\LessonPage;

class LessonSeeder extends Seeder
{
    public function run()
    {
        $module = Module::where('title', 'Variables and Data Types')->first();

        if ($module) {
            $lesson = Lesson::firstOrCreate([
                'module_id' => $module->id,
                'title' => 'Introduction to Variables',
            ], [
                'order' => 1
            ]);

            // Paginated content
            LessonPage::firstOrCreate([
                'lesson_id' => $lesson->id,
                'page_number' => 1
            ], [
                'content' => 'Variables are containers for storing data values.'
            ]);

            LessonPage::firstOrCreate([
                'lesson_id' => $lesson->id,
                'page_number' => 2
            ], [
                'content' => 'In Python: x = 5 assigns the integer 5 to variable x.'
            ]);

            LessonPage::firstOrCreate([
                'lesson_id' => $lesson->id,
                'page_number' => 3
            ], [
                'content' => 'Variables do not need to be declared with any particular type.'
            ]);
        }
    }
}
