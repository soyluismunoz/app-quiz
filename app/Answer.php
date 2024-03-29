<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
    protected $fillable = ['question_id', 'answer', 'correct'];
    
    public function question(){
        return $this->hasOne('App\Question', 'id', 'question_id');
    }
}
