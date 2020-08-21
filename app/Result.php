<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';

    protected $fillable = ['user_id', 'quiz_id', 'correct_answers', 'questions_count'];

    public function quiz(){
        return $this->belongsTo('App\Quiz');
    }

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /*public function options() {
        return $this->hasMany('App\UserOption', 'result_id', 'id');
    }*/
}
