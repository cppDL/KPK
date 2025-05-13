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
            Что такое Python?
            Python — это высокоуровневый, интерпретируемый язык программирования, созданный Гвидо ван Россумом в начале 1990-х годов.

            Он популярен благодаря:
            - Простому синтаксису (читается как английский язык)
            - Большому количеству библиотек
            - Кроссплатформенности (работает на Windows, macOS, Linux)

            Python широко используется:
            - в науке (анализ данных, машинное обучение),
            - в образовании (в том числе для самых начинающих),
            - в веб-разработке, автоматизации, и многом другом.
            EOT
            ]);
            

            LessonPage::create([
                'lesson_id' => $lesson->id,
                'page_number' => 2,
                'content' => <<<EOT
            Почему Python идеален для преподавателей?
            
            Профессора и преподаватели часто выбирают Python потому что:

            - Он прост в изучении — минимальный «порог входа»  
            - Подходит для преподавания базовых алгоритмов  
            - Имеет мощные библиотеки: NumPy, pandas, matplotlib, scikit-learn  
            - Легко интегрируется в научные исследования

            Пример:
            - Экономист может использовать Python для анализа статистики
            - Биолог — для моделирования данных
            - Преподаватель может использовать его в учебных курсах
            EOT
            ]);
            
            LessonPage::create([
                'lesson_id' => $lesson->id,
                'page_number' => 3,
                'content' => <<<EOT
            Установка Python
            
            Чтобы начать программировать, установите Python с официального сайта:

            https://www.python.org/downloads

            Во время установки убедитесь, что:
            - Вы поставили галочку «Add Python to PATH»
            - После установки запустите командную строку и проверьте:
            python --version
            
            Если всё в порядке, вы увидите версию, например:
            Python 3.12.1
            EOT
            ]);

            LessonPage::create([
                'lesson_id' => $lesson->id,
                'page_number' => 4,
                'content' => <<<EOT
            Выбор среды разработки (IDE)
            IDE (интегрированная среда разработки) — это программа, в которой удобно писать код.

            Рекомендуемые IDE:
            - **VS Code** — лёгкий, настраиваемый, с отличным расширением для Python
            - **PyCharm** — мощная среда от JetBrains, особенно для крупных проектов
            - **Jupyter Notebook** — особенно удобен для анализа данных и интерактивных лекций

            Мы начнем с простого примера:
            ```python
            print("Привет, Python!")
            EOT
            ]);
        }
    }
}
