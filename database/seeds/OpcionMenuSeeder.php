<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpcionMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('opcionmenu')->insert([
            'nombre' => 'Opcion Menu 1.1',
            'link' => 'admin/opcion1',
            'icono' => 'fa fa-user',
            'orden' => 1,
            'grupomenu_id' => 1
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Opcion Menu 1.2',
            'link' => 'admin/opcion2',
            'icono' => 'fa fa-car',
            'orden' => 2,
            'grupomenu_id' => 1
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Opcion Menu 2.1',
            'icono' => 'fa fa-list ',
            'link' => 'admin/opcion3',
            'orden' => 1,
            'grupomenu_id' => 2
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Opcion Menu 2.2',
            'icono' => 'fa fa-pen ',
            'link' => 'admin/opcion4',
            'orden' => 2,
            'grupomenu_id' => 2
        ]);
    }
}
