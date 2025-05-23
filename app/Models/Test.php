<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = ['title', 'course_id'];

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }
}

