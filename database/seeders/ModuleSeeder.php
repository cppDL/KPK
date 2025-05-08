<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Module;

class ModulesTableSeeder extends Seeder
{
    public function run()
    {
        $course = Course::where('slug', 'python-basics')->first();

        if ($course) {
            $module = Module::firstOrCreate([
                'course_id' => $course->id,
                'title' => 'Variables and Data Types'
            ], [
                'xp_reward' => 10
            ]);
        }
    }
}
