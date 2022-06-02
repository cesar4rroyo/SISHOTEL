<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 34; $i++) {
            DB::table('acceso')->insert([
                'tipousuario_id' => 1,
                'opcionmenu_id' => $i,
            ]);
        }
        // DB::table('acceso')->insert([
        //     'opcionmenu_id ' => 1,
        //     'tipousuario_id' => 1,
        // ]);
        // DB::table('acceso')->insert([
        //     'opcionmenu_id ' => 2,
        //     'tipousuario_id' => 1,
        // ]);
    }
}
