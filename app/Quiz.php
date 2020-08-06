<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quizzes';

    protected $fillable = ['title', 'status'];

    public function questions() {
        return $this->hasMany('App\Question', 'quiz_id', 'id');
    }
}
