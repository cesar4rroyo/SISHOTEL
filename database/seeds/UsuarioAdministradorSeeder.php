<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioAdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuario')->insert([
            'login' => 'admin',
            'password' => bcrypt('admin'),
            'tipousuario_id' => 1,
        ]);
        DB::table('usuario')->insert([
            'login' => 'hotel',
            'password' => bcrypt('hotel'),
            'tipousuario_id' => 2,
            'persona_id' => 2
        ]);
    }
}
