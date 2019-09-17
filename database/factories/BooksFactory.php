<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    return [
        'title'         => $faker->text(50),
        'description'   => $faker->text(200),
        'author'        => $faker->text(50),
        'field'         => $faker->text(25)
    ];
});
