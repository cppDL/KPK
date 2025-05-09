<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\LessonPage;

class LessonPageSeeder extends Seeder
{
    public function run()
    {
        $lessons = Lesson::all();

        foreach ($lessons as $lesson) {
            if ($lesson->pages()->exists()) {
                continue;
            }
            LessonPage::create([
                'lesson_id' => $lesson->id,
                'page_number' => 1,
                'content' => <<<EOT
            Python is a high-level, interpreted programming language known for its simplicity and readability. 
            Originally created by Guido van Rossum in the early 1990s, Python is now one of the most widely-used languages in academia, research, and industry.
            
            Its clear syntax and strong standard library make it ideal for teaching programming fundamentals and rapid application development.
            EOT
            ]);
            

            LessonPage::create([
                'lesson_id' => $lesson->id,
                'page_number' => 2,
                'content' => <<<EOT
            Python supports multiple programming paradigms including procedural, object-oriented, and functional programming.
            
            In academia, Python is often used for:
            - Data analysis (via pandas, NumPy)
            - Machine learning (via scikit-learn, TensorFlow)
            - Simulation and automation
            - Teaching introductory programming
            
            Its versatility makes it a strong choice for professors across disciplines.
            EOT
            ]);
            
            LessonPage::create([
                'lesson_id' => $lesson->id,
                'page_number' => 3,
                'content' => <<<EOT
            To begin writing Python code, you must install the Python interpreter on your system.
            
            Download the latest version from [https://www.python.org/downloads](https://www.python.org/downloads).
            
            Make sure to:
            - Add Python to your system PATH during installation
            - Verify the install using `python --version` in your terminal or command prompt
            EOT
            ]);

            LessonPage::create([
                'lesson_id' => $lesson->id,
                'page_number' => 4,
                'content' => <<<EOT
            Next, install an Integrated Development Environment (IDE). Popular options include:
            
            - **VS Code** (recommended): Lightweight, customizable, great extensions for Python.
            - **PyCharm**: Full-featured, best for larger projects.
            - **Jupyter Notebook**: Ideal for data analysis and interactive teaching.
            
            Install the Python extension in your IDE and test by running a simple script like:
            ```python
            print("Hello, Python!")
            EOT
            ]);
        }
    }
}
