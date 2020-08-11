<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $fillable = ['quiz_id', 'title', 'min', 'seg' ];

    public function quiz() {
        return $this->hasOne('App\Quiz', 'id', 'quiz_id');
    }

    public function answers() {
        return $this->hasMany('App\Answer', 'question_id', 'id');
    }

    public function correctAnswerCount() {
        return $this->answer()->where('correct', 1 )->count();
    }

    public function correctAnswer() {
       return  $this->Answer()->where('correct', 1)->get();
    }
}
