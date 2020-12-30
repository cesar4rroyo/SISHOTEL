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
        ]);
        //2
        DB::table('tipohabitacion')->insert([
            'nombre' => 'Habitación Matr. Standard',
            'precio' => 200,
        ]);
        //3
        DB::table('tipohabitacion')->insert([
            'nombre' => 'Habitación Matr. Superior',
            'precio' => 200,
        ]);
        //4
        DB::table('tipohabitacion')->insert([
            'nombre' => 'Bungalow Standard',
            'precio' => 350,
        ]);
        //5
        DB::table('tipohabitacion')->insert([
            'nombre' => 'Bungalow Superior',
            'precio' => 400,
        ]);
    }
}
