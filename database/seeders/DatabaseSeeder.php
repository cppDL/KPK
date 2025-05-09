<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course; // Add this import
use App\Models\Module; // Add this if using modules

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CourseSeeder::class,
            ModuleSeeder::class,
            LessonSeeder::class,
            LessonPageSeeder::class,
        ]);
    }

}