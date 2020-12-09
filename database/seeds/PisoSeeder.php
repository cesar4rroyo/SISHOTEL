<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PisoSeeder extends Seeder
{

    public function run()
    {
        DB::table('piso')->insert([
            'nombre' => 'Piso 1',
        ]);
        DB::table('piso')->insert([
            'nombre' => 'Piso 2',
        ]);
        DB::table('piso')->insert([
            'nombre' => 'Piso 3',
        ]);
        DB::table('piso')->insert([
            'nombre' => 'Piso 4',
        ]);
    }
}
