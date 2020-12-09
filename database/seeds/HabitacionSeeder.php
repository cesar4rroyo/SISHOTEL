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
            'numero' => 1,
            'situacion' => 'Excelente',
            'piso_id' => 1,
            'tipohabitacion_id' => 1
        ]);

        DB::table('habitacion')->insert([
            'numero' => 2,
            'situacion' => 'Mala',
            'piso_id' => 1,
            'tipohabitacion_id' => 1
        ]);
        DB::table('habitacion')->insert([
            'numero' => 3,
            'situacion' => 'Bien',
            'piso_id' => 2,
            'tipohabitacion_id' => 2
        ]);

        DB::table('habitacion')->insert([
            'numero' => 4,
            'situacion' => 'Mala',
            'piso_id' => 2,
            'tipohabitacion_id' => 2
        ]);
    }
}
