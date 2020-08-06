<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';

    public function topic(){
        return $this->belongsTo('App\Quiz');
    }

    public function participant() {
        return $this->hasOne('App\Participant', 'id', 'participant_id');
    }

    /*public function options() {
        return $this->hasMany('App\UserOption', 'result_id', 'id');
    }*/
}
