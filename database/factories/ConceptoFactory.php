<?php

use App\Models\Concepto;
use Faker\Generator as Faker;

$factory->define(Concepto::class, function (Faker $faker) {
    return [
        'nombre' => $faker->unique()->word,
        'tipo' => $faker->word,
    ];
});
