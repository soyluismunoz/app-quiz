<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Quiz;
use Faker\Generator as Faker;

$factory->define(Quiz::class, function (Faker $faker) {
    $name = $faker->sentence(3);    
    return [
        'title'         => $name,
        'description'   => $faker->sentence(10),
        'approve_with'  => rand(1, 5),
        'if_approve'    => 'Aprobaste ' . $faker->sentence(5),
        'if_fail'       => 'Fallaste ' . $faker->sentence(5),
        'slug'          => Str::slug($name),
        'hour'          => 0,
        'min'           => rand(1, 5),
        'seg'           => rand(0, 60),
        'status'        => $faker->randomElement(['inactive', 'active'])
    ];
});
