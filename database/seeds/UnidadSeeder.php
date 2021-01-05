<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unidad')->insert([
            'nombre' => 'Unidad',
        ]);

        DB::table('unidad')->insert([
            'nombre' => 'Caja',
        ]);
    }
}
