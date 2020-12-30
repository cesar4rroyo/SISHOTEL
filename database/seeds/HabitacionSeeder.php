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
            'numero' => 201,
            'situacion' => 'Disponible',
            'piso_id' => 1,
            'tipohabitacion_id' => 4
        ]);

        DB::table('habitacion')->insert([
            'numero' => 202,
            'situacion' => 'Disponible',
            'piso_id' => 1,
            'tipohabitacion_id' => 5
        ]);
        DB::table('habitacion')->insert([
            'numero' => 301,
            'situacion' => 'Disponible',
            'piso_id' => 2,
            'tipohabitacion_id' => 2
        ]);
        DB::table('habitacion')->insert([
            'numero' => 302,
            'situacion' => 'Disponible',
            'piso_id' => 2,
            'tipohabitacion_id' => 1
        ]);
        DB::table('habitacion')->insert([
            'numero' => 303,
            'situacion' => 'Disponible',
            'piso_id' => 2,
            'tipohabitacion_id' => 3
        ]);
        DB::table('habitacion')->insert([
            'numero' => 304,
            'situacion' => 'Disponible',
            'piso_id' => 2,
            'tipohabitacion_id' => 3
        ]);
        DB::table('habitacion')->insert([
            'numero' => 305,
            'situacion' => 'Disponible',
            'piso_id' => 2,
            'tipohabitacion_id' => 3
        ]);
        DB::table('habitacion')->insert([
            'numero' => 306,
            'situacion' => 'Disponible',
            'piso_id' => 2,
            'tipohabitacion_id' => 3
        ]);
        DB::table('habitacion')->insert([
            'numero' => 307,
            'situacion' => 'Disponible',
            'piso_id' => 2,
            'tipohabitacion_id' => 3
        ]);
        DB::table('habitacion')->insert([
            'numero' => 401,
            'situacion' => 'Disponible',
            'piso_id' => 3,
            'tipohabitacion_id' => 2
        ]);

        DB::table('habitacion')->insert([
            'numero' => 402,
            'situacion' => 'Disponible',
            'piso_id' => 3,
            'tipohabitacion_id' => 1
        ]);
        DB::table('habitacion')->insert([
            'numero' => 403,
            'situacion' => 'Disponible',
            'piso_id' => 3,
            'tipohabitacion_id' => 3
        ]);
        DB::table('habitacion')->insert([
            'numero' => 404,
            'situacion' => 'Disponible',
            'piso_id' => 3,
            'tipohabitacion_id' => 3
        ]);
    }
}
