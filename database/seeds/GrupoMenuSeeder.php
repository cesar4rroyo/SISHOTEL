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
            'nombre' => 'Administración',
            'icono' => 'fas fa-users-cog',
            'orden' => 1,
        ]);

        DB::table('grupomenu')->insert([
            'nombre' => 'Personas',
            'icono' => 'fas fa-user-tie',
            'orden' => 2,
        ]);
        DB::table('grupomenu')->insert([
            'nombre' => 'Usuarios',
            'icono' => 'fas fa-users',
            'orden' => 3,
        ]);
        DB::table('grupomenu')->insert([
            'nombre' => 'Reservas',
            'icono' => 'fas fa-box-open',
            'orden' => 4,
        ]);
        DB::table('grupomenu')->insert([
            'nombre' => 'Control General',
            'icono' => 'fas fa-shopping-cart',
            'orden' => 5,
        ]);
    }
}
