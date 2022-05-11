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
        //HABITACIONES DOBLES
        DB::table('habitacion')->insert([
            'numero' => 101,
            'situacion' => 'Disponible',
            'piso_id' => 1,
            'tipohabitacion_id' => 2
        ]);
        DB::table('habitacion')->insert([
            'numero' => 108,
            'situacion' => 'Disponible',
            'piso_id' => 2,
            'tipohabitacion_id' => 2
        ]);
        DB::table('habitacion')->insert([
            'numero' => 113,
            'situacion' => 'Disponible',
            'piso_id' => 2,
            'tipohabitacion_id' => 2
        ]);

        //HABITACIONES MATRIMONIALES
        DB::table('habitacion')->insert([
            'numero' => 102,
            'situacion' => 'Disponible',
            'piso_id' => 1,
            'tipohabitacion_id' => 3
        ]);
        DB::table('habitacion')->insert([
            'numero' => 103,
            'situacion' => 'Disponible',
            'piso_id' => 1,
            'tipohabitacion_id' => 3
        ]);
        DB::table('habitacion')->insert([
            'numero' => 104,
            'situacion' => 'Disponible',
            'piso_id' => 1,
            'tipohabitacion_id' => 3
        ]);
        DB::table('habitacion')->insert([
            'numero' => 105,
            'situacion' => 'Disponible',
            'piso_id' => 1,
            'tipohabitacion_id' => 3
        ]);
        DB::table('habitacion')->insert([
            'numero' => 106,
            'situacion' => 'Disponible',
            'piso_id' => 1,
            'tipohabitacion_id' => 3
        ]);
        DB::table('habitacion')->insert([
            'numero' => 107,
            'situacion' => 'Disponible',
            'piso_id' => 1,
            'tipohabitacion_id' => 3
        ]);
        DB::table('habitacion')->insert([
            'numero' => 109,
            'situacion' => 'Disponible',
            'piso_id' => 2,
            'tipohabitacion_id' => 3
        ]);
        DB::table('habitacion')->insert([
            'numero' => 110,
            'situacion' => 'Disponible',
            'piso_id' => 2,
            'tipohabitacion_id' => 3
        ]);
        DB::table('habitacion')->insert([
            'numero' => 111,
            'situacion' => 'Disponible',
            'piso_id' => 2,
            'tipohabitacion_id' => 3
        ]);
        DB::table('habitacion')->insert([
            'numero' => 112,
            'situacion' => 'Disponible',
            'piso_id' => 2,
            'tipohabitacion_id' => 3
        ]);

        //HABITACIONES MAT. CON BANO COMPARTIDO
        DB::table('habitacion')->insert([
            'numero' => 114,
            'situacion' => 'Disponible',
            'piso_id' => 3,
            'tipohabitacion_id' => 4
        ]);
        DB::table('habitacion')->insert([
            'numero' => 115,
            'situacion' => 'Disponible',
            'piso_id' => 3,
            'tipohabitacion_id' => 4
        ]);
        DB::table('habitacion')->insert([
            'numero' => 116,
            'situacion' => 'Disponible',
            'piso_id' => 3,
            'tipohabitacion_id' => 4
        ]);
        DB::table('habitacion')->insert([
            'numero' => 117,
            'situacion' => 'Disponible',
            'piso_id' => 3,
            'tipohabitacion_id' => 4
        ]);
        DB::table('habitacion')->insert([
            'numero' => 118,
            'situacion' => 'Disponible',
            'piso_id' => 3,
            'tipohabitacion_id' => 4
        ]);

    }
}
