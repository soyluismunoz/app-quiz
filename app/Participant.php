<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $table = 'participants';
    protected $fillable = ['name', 'email'];

    public function results() {
        return $this->hasMany('App\Result', 'participant_id', 'id');
    }

    public function quizCount() {
        return $this->results()->count();
    }
}
