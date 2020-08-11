<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    $name = $faker->sentence(3);    
    return [
        'answer'        => $name ,
        'correct'       => rand(0, 1),
    ];
});