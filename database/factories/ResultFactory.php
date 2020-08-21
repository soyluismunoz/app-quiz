<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Result;
use Faker\Generator as Faker;

$factory->define(Result::class, function (Faker $faker) {
    return [
        'user_id' => rand(1, 6), 
        'quiz_id' => rand(1, 6), 
        'correct_answers' => rand(3, 4), 
        'questions_count' => rand(4,5) 
    ];
});
