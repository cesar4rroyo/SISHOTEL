<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoHabitacionSeeder extends Seeder
{

    public function run()
    {
        //1
        DB::table('tipohabitacion')->insert([
            'nombre' => 'Habitación Simple',
            'precio' => 120,
            'capacidad' => 1,
        ]);
        //2
        DB::table('tipohabitacion')->insert([
            'nombre' => 'Habitación Matr. Standard',
            'precio' => 200,
            'capacidad' => 2,

        ]);
        //3
        DB::table('tipohabitacion')->insert([
            'nombre' => 'Habitación Matr. Superior',
            'precio' => 200,
            'capacidad' => 2,

        ]);
        //4
        DB::table('tipohabitacion')->insert([
            'nombre' => 'Bungalow Standard',
            'precio' => 350,
            'capacidad' => 4,

        ]);
        //5
        DB::table('tipohabitacion')->insert([
            'nombre' => 'Bungalow Superior',
            'precio' => 400,
            'capacidad' => 5,

        ]);
    }
}
