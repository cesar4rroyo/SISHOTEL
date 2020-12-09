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
        ]);
        DB::table('usuario')->insert([
            'login' => 'hotel',
            'password' => bcrypt('hotel'),
        ]);
    }
}
