<?php

use App\Models\Servicios;
use Faker\Generator as Faker;

$factory->define(Servicios::class, function (Faker $faker) {
    return [
        'nombre' => $faker->unique()->word,
        'precio' => $faker->randomDigitNotNull
    ];
});
