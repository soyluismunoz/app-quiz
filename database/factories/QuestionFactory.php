<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    $name = $faker->sentence(3);    
    return [
        'title'     => $name ,
        'quiz_id'   => rand(1, 6),
        'min'       => rand(1, 5),
        'seg'       => rand(0, 60)
    ];
});
