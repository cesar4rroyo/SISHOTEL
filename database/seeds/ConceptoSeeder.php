<?php

use App\Models\Concepto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConceptoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Concepto ID=1 => Apertura Caja no cambiar
        DB::table('concepto')->insert([
            'nombre' => 'Apertura Caja',
            'tipo' => 'Ingreso',
        ]);
        //Concepto ID=1 => Cierre Caja no cambiar
        DB::table('concepto')->insert([
            'nombre' => 'Cierre Caja',
            'tipo' => 'Egreso',
        ]);
        DB::table('concepto')->insert([
            'nombre' => 'Pago de Cliente',
            'tipo' => 'Ingreso',
        ]);
        DB::table('concepto')->insert([
            'nombre' => 'Concepto 2',
            'tipo' => 'Egreso',
        ]);
    }
}
