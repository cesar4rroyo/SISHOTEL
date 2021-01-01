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
        //start Grupo Administracion
        DB::table('opcionmenu')->insert([
            'nombre' => 'Producto',
            'link' => 'admin/producto',
            'icono' => 'fa fa-gift',
            'orden' => 1,
            'grupomenu_id' => 1
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Categorías',
            'link' => 'admin/categoria',
            'icono' => 'fas fa-gifts',
            'orden' => 2,
            'grupomenu_id' => 1
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Unidad',
            'icono' => 'fas fa-money-bill-alt',
            'link' => 'admin/unidad',
            'orden' => 3,
            'grupomenu_id' => 1
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Servicios',
            'icono' => 'fas fa-concierge-bell',
            'link' => 'admin/servicios',
            'orden' => 4,
            'grupomenu_id' => 1
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Concepto',
            'icono' => 'fas fa-concierge-bell',
            'link' => 'admin/concepto',
            'orden' => 5,
            'grupomenu_id' => 1
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Habitacion',
            'link' => 'admin/habitacion',
            'icono' => 'fas fa-h-square',
            'orden' => 6,
            'grupomenu_id' => 1
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Tipo Habitacion',
            'icono' => 'fas fa-shower',
            'link' => 'admin/tipohabitacion',
            'orden' => 7,
            'grupomenu_id' => 1
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Pisos',
            'icono' => 'fas fa-hotel',
            'link' => 'admin/piso',
            'orden' => 8,
            'grupomenu_id' => 1
        ]);
        //end Grupo Administracion

        //start Grupo Persona
        DB::table('opcionmenu')->insert([
            'nombre' => 'Personas',
            'icono' => 'fas fa-user-alt',
            'link' => 'admin/persona',
            'orden' => 1,
            'grupomenu_id' => 4
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Nacionalidad',
            'icono' => 'fas fa-globe-americas',
            'link' => 'admin/nacionalidad',
            'orden' => 2,
            'grupomenu_id' => 4
        ]);
        //end Grupo Persona

        //start Grupo Usuarios
        DB::table('opcionmenu')->insert([
            'nombre' => 'Usuario',
            'link' => 'admin/usuario',
            'icono' => 'fas fa-user',
            'orden' => 1,
            'grupomenu_id' => 5
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Roles',
            'link' => 'admin/rol',
            'icono' => 'fas fa-users-cog',
            'orden' => 2,
            'grupomenu_id' => 5
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Rol Persona',
            'icono' => 'fas fa-user-plus',
            'link' => 'admin/rolpersona',
            'orden' => 3,
            'grupomenu_id' => 5
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Tipos Usuario',
            'icono' => 'fas fa-users-slash',
            'link' => 'admin/tipousuario',
            'orden' => 4,
            'grupomenu_id' => 5
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Accesos',
            'link' => 'admin/acceso',
            'icono' => 'fas fa-people-arrows',
            'orden' => 5,
            'grupomenu_id' => 5
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Opciones de Menú',
            'icono' => 'fas fa-stream',
            'link' => 'admin/opcionmenu',
            'orden' => 6,
            'grupomenu_id' => 5
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Grupos de Menú',
            'icono' => 'fas fa-list-ol',
            'link' => 'admin/grupomenu',
            'orden' => 7,
            'grupomenu_id' => 5
        ]);
        //end Grupo Usuarios
        //start Grupo Reservas
        DB::table('opcionmenu')->insert([
            'nombre' => 'Reservas',
            'link' => 'admin/reserva',
            'icono' => 'fas fa-h-square',
            'orden' => 1,
            'grupomenu_id' => 6
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Lista de Reservas',
            'link' => 'admin/reserva/todas/list',
            'icono' => 'fas fa-list-ol',
            'orden' => 2,
            'grupomenu_id' => 6
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Habitaciones',
            'link' => 'admin/habitaciones',
            'icono' => 'fas fa-h-square',
            'orden' => 1,
            'grupomenu_id' => 2
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Check-Outs',
            'link' => 'admin/movimiento/checkouts/lista',
            'icono' => 'fas fa-list-ol',
            'orden' => 2,
            'grupomenu_id' => 2
        ]);
        //end Grupo Reservas
        DB::table('opcionmenu')->insert([
            'nombre' => 'Caja',
            'link' => 'admin/caja',
            'icono' => 'fas fa-h-square',
            'orden' => 1,
            'grupomenu_id' => 3
        ]);

        DB::table('opcionmenu')->insert([
            'nombre' => 'Movimientos de Caja',
            'link' => 'admin/caja/lista',
            'icono' => 'fas fa-clipboard-list',
            'orden' => 2,
            'grupomenu_id' => 3
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Productos',
            'link' => 'admin/ventas/productos',
            'icono' => 'fas fa-clipboard-list',
            'orden' => 1,
            'grupomenu_id' => 7
        ]);
        DB::table('opcionmenu')->insert([
            'nombre' => 'Servicios',
            'link' => 'admin/ventas/servicios',
            'icono' => 'fas fa-clipboard-list',
            'orden' => 2,
            'grupomenu_id' => 7
        ]);
    }
}
