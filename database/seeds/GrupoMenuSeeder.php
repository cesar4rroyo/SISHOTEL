<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GrupoMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grupomenu')->insert([
            'nombre' => 'Grupo Menu 1',
            'icono' => 'fa fa-user',
            'orden' => 1,
        ]);

        DB::table('grupomenu')->insert([
            'nombre' => 'Grupo Menu 2',
            'icono' => 'fa fa-list ',
            'orden' => 2,
        ]);
    }
}
