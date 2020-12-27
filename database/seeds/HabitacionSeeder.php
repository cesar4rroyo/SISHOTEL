<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HabitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('habitacion')->insert([
            'numero' => 101,
            'situacion' => 'Disponible',
            'piso_id' => 1,
            'tipohabitacion_id' => 1
        ]);

        DB::table('habitacion')->insert([
            'numero' => 102,
            'situacion' => 'Ocupada',
            'piso_id' => 1,
            'tipohabitacion_id' => 1
        ]);
        DB::table('habitacion')->insert([
            'numero' => 103,
            'situacion' => 'Ocupada',
            'piso_id' => 1,
            'tipohabitacion_id' => 1
        ]);
        DB::table('habitacion')->insert([
            'numero' => 201,
            'situacion' => 'Limpieza',
            'piso_id' => 2,
            'tipohabitacion_id' => 2
        ]);

        DB::table('habitacion')->insert([
            'numero' => 202,
            'situacion' => 'Disponible',
            'piso_id' => 2,
            'tipohabitacion_id' => 2
        ]);
        DB::table('habitacion')->insert([
            'numero' => 203,
            'situacion' => 'Disponible',
            'piso_id' => 2,
            'tipohabitacion_id' => 2
        ]);
    }
}
