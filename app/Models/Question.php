<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['test_id', 'question', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_option'];

    public function test() {
        return $this->belongsTo(Test::class);
    }
}
