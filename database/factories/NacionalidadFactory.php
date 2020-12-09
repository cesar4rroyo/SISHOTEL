<?php

use App\Models\Nacionalidad;
use Faker\Generator as Faker;

$factory->define(Nacionalidad::class, function (Faker $faker) {
    return [
        'nombre' => $faker->unique()->country,
    ];
});
