<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;

// class CourseSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         $course = Course::create([
//             'title' => 'Python Basics',
//             'slug' => 'python-basics',
//             'description' => 'Learn Python from scratch.',
//         ]);
    
//         $module = $course->modules()->create([
//             'title' => 'Variables & Loops',
//             'xp_reward' => 20,
//         ]);
    
//         $module->lessons()->create([
//             'type' => 'code',
//             'content' => ['prompt' => 'Write a function that prints "Hello World"'],
//             'solution' => ['code' => 'print("Hello World")'],
//         ]);
//     }
// }

class CourseSeeder extends Seeder
{
    public function run()
    {
        $course = Course::create([
            'title' => 'Python Basics',
            'slug' => 'python-basics',
            'description' => 'Intro to Python programming',
            'is_active' => true
        ]);

        $course->modules()->create([
            'title' => 'Variables and Data Types',
            'xp_reward' => 10
        ]);
    }
}