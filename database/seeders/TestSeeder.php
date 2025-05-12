<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Test;
use App\Models\Question;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;

class TestSeeder extends Seeder
{
    public function run()
    {
        $course = Course::first();

        if (!$course) 
        {
            $this->command->warn('No courses found. Please seed courses first.');
        return;
        }

        $test = Test::firstOrCreate([
            'title' => 'Quiz: Intro to Variables',
            'course_id' => $course->id,
        ]);

        Question::updateOrCreate([
            'test_id' => $test->id,
            'question' => 'Which of the following is a valid variable name in Python?'
        ], [
            'option_a' => '2variable',
            'option_b' => 'variable-name',
            'option_c' => '_variable',
            'option_d' => 'variable name',
            'correct_option' => 'c',
        ]);

        Question::updateOrCreate([
            'test_id' => $test->id,
            'question' => 'What is the output of `type(5.0)`?'
        ], [
            'option_a' => '<class \'int\'>',
            'option_b' => '<class \'float\'>',
            'option_c' => '<class \'str\'>',
            'option_d' => '<class \'bool\'>',
            'correct_option' => 'b',
        ]);

        Question::updateOrCreate([
            'test_id' => $test->id,
            'question' => 'Which data type is mutable in Python?'
        ], [
            'option_a' => 'int',
            'option_b' => 'str',
            'option_c' => 'tuple',
            'option_d' => 'list',
            'correct_option' => 'd',
        ]);
    }
}
