<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Lesson;

class LessonsTableSeeder extends Seeder
{
    public function run()
    {
        $module = Module::where('title', 'Variables and Data Types')->first();

        if ($module) {
            Lesson::firstOrCreate([
                'module_id' => $module->id,
                'title' => 'Introduction to Variables'
            ], [
                'content' => 'Variables store data. In Python, you create them like: x = 5.',
                'order' => 1
            ]);

            Lesson::firstOrCreate([
                'module_id' => $module->id,
                'title' => 'Data Types Overview'
            ], [
                'content' => 'Python has int, float, str, and more.',
                'order' => 2
            ]);
        }
    }
}
