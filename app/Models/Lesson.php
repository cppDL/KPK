<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['module_id', "title"];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function pages()
    {
        return $this->hasMany(LessonPage::class)->orderBy('page_number');
    }
}
