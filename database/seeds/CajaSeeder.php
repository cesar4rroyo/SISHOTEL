<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('caja')->insert([
            'fecha' => Carbon::now(),
            'tipo' => 'Configuración Inicial Caja',
            'numero' => '0',
            'total' => 0,
            'comentario' => 'Configuración Inicial de Caja',
            'concepto_id' => 2,
            'usuario_id' => 1
        ]);
    }
}
