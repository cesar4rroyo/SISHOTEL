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
            'nombre' => 'Control General',
            'icono' => 'fas fa-columns',
            'orden' => 2,
        ]);
        DB::table('grupomenu')->insert([
            'nombre' => 'Caja',
            'icono' => 'fas fa-box-open',
            'orden' => 3,
        ]);

        DB::table('grupomenu')->insert([
            'nombre' => 'Personas',
            'icono' => 'fas fa-user-tie',
            'orden' => 4,
        ]);
        DB::table('grupomenu')->insert([
            'nombre' => 'Usuarios',
            'icono' => 'fas fa-users',
            'orden' => 5,
        ]);
        DB::table('grupomenu')->insert([
            'nombre' => 'Reservas',
            'icono' => 'fas fa-calendar-check',
            'orden' => 6,
        ]);
        DB::table('grupomenu')->insert([
            'nombre' => 'Ventas',
            'icono' => 'fas fa-store',
            'orden' => 7,
        ]);
        DB::table('grupomenu')->insert([
            'nombre' => 'Comprobantes',
            'icono' => 'fas fa-list-ol',
            'orden' => 8,
        ]);
        DB::table('grupomenu')->insert([
            'nombre' => 'Reportes',
            'icono' => 'fas fa-chart-bar',
            'orden' => 9,
        ]);
    }
}
