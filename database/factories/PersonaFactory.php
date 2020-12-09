<?php

use App\Models\Persona;
use Faker\Generator as Faker;

$factory->define(Persona::class, function (Faker $faker) {
    return [
        'nombres' => $faker->firstName,
        'apellidos' => $faker->lastName,
        'razonsocial' => $faker->word,
        'ruc' => $faker->creditCardNumber,
        'dni' => $faker->unique()->randomDigitNotNull,
        'direccion' => $faker->address,
        'sexo' => $faker->randomLetter,
        'fechanacimiento' => $faker->dateTimeThisCentury,
        'telefono' => $faker->phoneNumber,
        'observacion' => $faker->text,
        'nacionalidad_id' => $faker->unique(true)->numberBetween(1, 21),
    ];
});
