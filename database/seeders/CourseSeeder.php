<?php

// namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;
// use App\Models\Course;
// use App\Models\Module;
// use App\Models\Lesson;

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run()
    {
        Course::firstOrCreate([
            'slug' => 'python-basics',
        ], [
            'title' => 'Python Basics',
            'description' => 'Intro to Python programming',
            'status' => Course::STATUS_AVAILABLE

        ]);
    }
}
