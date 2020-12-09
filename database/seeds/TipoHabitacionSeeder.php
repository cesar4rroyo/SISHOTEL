<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoHabitacionSeeder extends Seeder
{

    public function run()
    {
        DB::table('tipohabitacion')->insert([
            'nombre' => 'Tipo 1',
            'precio' => 20,
        ]);
        DB::table('tipohabitacion')->insert([
            'nombre' => 'Tipo 2',
            'precio' => 40,
        ]);
    }
}
