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
            'precio' => 30,
            'capacidad' => 4,
        ]);
        //2
        DB::table('tipohabitacion')->insert([
            'nombre' => 'Habitación Doble',
            'precio' => 50,
            'capacidad' => 4,

        ]);
        //3
        DB::table('tipohabitacion')->insert([
            'nombre' => 'Habitación Matrimonial',
            'precio' => 30,
            'capacidad' => 4,

        ]);
        //4
        DB::table('tipohabitacion')->insert([
            'nombre' => 'Habitacion Matrimonial con Baño Compartido',
            'precio' => 25,
            'capacidad' => 4,

        ]);
    }
}
