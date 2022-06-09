<?php

use App\Models\Categoria;
use App\Models\Procesos\Caja;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->truncateTablas([
            'tipohabitacion',
            'piso',
            'concepto',
            'servicios',
            'categoria',
            'unidad',
            'nacionalidad',
            'rol',
            'grupomenu',
            'tipousuario',
            'habitacion',
            'producto',
            'opcionmenu',
            'persona',
            'usuario',
            'acceso',

        ]);
        $this->call(TipoHabitacionSeeder::class);
        $this->call(PisoSeeder::class);
        $this->call(ConceptoSeeder::class);
        $this->call(ServiciosSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(UnidadSeeder::class);
        $this->call(NacionalidadSeeder::class);
        $this->call(RolSeeder::class);
        $this->call(GrupoMenuSeeder::class);
        $this->call(TipoUsuarioSeeder::class);
        $this->call(HabitacionSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(OpcionMenuSeeder::class);
        $this->call(PersonaSeeder::class);
        $this->call(UsuarioAdministradorSeeder::class);
        $this->call(AccesoSeeder::class);
    }

    protected function truncateTablas(array $tablas)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        foreach ($tablas as $tabla) {
            DB::table($tabla)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
