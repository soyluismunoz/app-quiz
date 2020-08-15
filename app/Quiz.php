<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quizzes';

    protected $fillable = [
        'title', 
        'description',
        'approve_with',
        'if_approve',
        'if_fail',
        'slug', 
        'hour', 
        'min', 
        'seg', 
        'status'
    ];

    public function questions() {
        return $this->hasMany('App\Question', 'quiz_id', 'id');
    }
}
