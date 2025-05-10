<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = ['title', 'course_id', 'module_id', 'lesson_id'];

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function module() {
        return $this->belongsTo(Module::class);
    }

    public function lesson() {
        return $this->belongsTo(Lesson::class);
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }
}

