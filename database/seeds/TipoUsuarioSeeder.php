<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipousuario')->insert([
            'nombre' => 'Administrador Principal',
        ]);
        DB::table('tipousuario')->insert([
            'nombre' => 'Administrador',
        ]);
        DB::table('tipousuario')->insert([
            'nombre' => 'Almacen',
        ]);
        DB::table('tipousuario')->insert([
            'nombre' => 'Cajero',
        ]);
        DB::table('tipousuario')->insert([
            'nombre' => 'Usuario',
        ]);
    }
}
