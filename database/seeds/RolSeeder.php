<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rol')->insert([
            'nombre' => 'Usuario',
        ]);
        DB::table('rol')->insert([
            'nombre' => 'Cliente',
        ]);
        DB::table('rol')->insert([
            'nombre' => 'Provedor',
        ]);
        DB::table('rol')->insert([
            'nombre' => 'Personal',
        ]);
    }
}
