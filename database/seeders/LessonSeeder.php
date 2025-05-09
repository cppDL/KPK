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
            Lesson::firstOrCreate([
                'module_id' => $module->id,
                'title' => 'Introduction to Variables',
            ], ['order' => 1]);

            Lesson::firstOrCreate([
                'module_id' => $module->id,
                'title' => 'Data Types',
            ], ['order' => 2]);

            Lesson::firstOrCreate([
                'module_id' => $module->id,
                'title' => 'Variable Naming Rules',
            ], ['order' => 3]);

            Lesson::firstOrCreate([
                'module_id' => $module->id,
                'title' => 'Type Conversion',
            ], ['order' => 4]);
        }
    }
}
