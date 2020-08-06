<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Quiz;
use Faker\Generator as Faker;

$factory->define(Quiz::class, function (Faker $faker) {
    $name = $faker->sentence(3);    
    return [
        'title' => $name ,
        'slug'  => Str::slug($name),
        'status' => $faker->randomElement(['active', 'inactive']),
    ];
});
