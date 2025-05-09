<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonPage extends Model
{
    protected $fillable = ['lesson_id', 'page_number', 'content'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
