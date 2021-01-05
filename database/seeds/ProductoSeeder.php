<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('producto')->insert([
            'nombre' => 'Heno de Pravia Jabón Blanco',
            'precioventa' => 5,
            'categoria_id' => 1,
            'unidad_id' => 1,
        ]);

        DB::table('producto')->insert([
            'nombre' => 'Heno de Pravia Jabón Verde',
            'precioventa' => 5,
            'categoria_id' => 1,
            'unidad_id' => 2
        ]);
        DB::table('producto')->insert([
            'nombre' => 'Jabón SPA',
            'precioventa' => 3,
            'categoria_id' => 1,
            'unidad_id' => 1
        ]);

        DB::table('producto')->insert([
            'nombre' => 'PANTENE Crema para peinar',
            'precioventa' => 2,
            'categoria_id' => 1,
            'unidad_id' => 1,
        ]);
        DB::table('producto')->insert([
            'nombre' => 'Papel Higiénico Suave(2rollos)',
            'precioventa' => 1.5,
            'categoria_id' => 1,
            'unidad_id' => 1,
        ]);

        DB::table('producto')->insert([
            'nombre' => 'Gillette Venus Simply 3',
            'precioventa' => 5,
            'categoria_id' => 1,
            'unidad_id' => 2
        ]);
        DB::table('producto')->insert([
            'nombre' => 'Gillette Prestobarba 3',
            'precioventa' => 5,
            'categoria_id' => 1,
            'unidad_id' => 1
        ]);

        DB::table('producto')->insert([
            'nombre' => 'Colgate Triple Acción',
            'precioventa' => 3,
            'categoria_id' => 1,
            'unidad_id' => 1,
        ]);
        DB::table('producto')->insert([
            'nombre' => 'Kolynos Triple Limpieza',
            'precioventa' => 6,
            'categoria_id' => 1,
            'unidad_id' => 2
        ]);
        DB::table('producto')->insert([
            'nombre' => 'Cajas de Fósforo',
            'categoria_id' => 1,
            'unidad_id' => 1
        ]);

        DB::table('producto')->insert([
            'nombre' => 'Mascarillas',
            'precioventa' => 1,
            'categoria_id' => 1,
            'unidad_id' => 1,
        ]);
        DB::table('producto')->insert([
            'nombre' => 'Desodorante Rexona Mujer',
            'precioventa' => 1.5,
            'categoria_id' => 1,
            'unidad_id' => 1,
        ]);
        DB::table('producto')->insert([
            'nombre' => 'Head & Shoulders Limpieza Renovadora',
            'precioventa' => 2,
            'categoria_id' => 1,
            'unidad_id' => 1,
        ]);
        DB::table('producto')->insert([
            'nombre' => 'Nosotras Buenas Noches Invisible',
            'precioventa' => 1.5,
            'categoria_id' => 1,
            'unidad_id' => 1,
        ]);
        DB::table('producto')->insert([
            'nombre' => 'Nosotras Diarias(pack x 15)',
            'precioventa' => 5,
            'categoria_id' => 1,
            'unidad_id' => 1,
        ]);
        DB::table('producto')->insert([
            'nombre' => 'Nosotras Diarias Normal',
            'precioventa' => 1,
            'categoria_id' => 1,
            'unidad_id' => 1,
        ]);
        DB::table('producto')->insert([
            'nombre' => 'Kotex Ultra Flexible',
            'precioventa' => 1.5,
            'categoria_id' => 1,
            'unidad_id' => 1,
        ]);
        DB::table('producto')->insert([
            'nombre' => 'Nosotras Buenas Noches',
            'precioventa' => 1.5,
            'categoria_id' => 1,
            'unidad_id' => 1,
        ]);
        DB::table('producto')->insert([
            'nombre' => 'Nosotras Invisible Rapigel',
            'precioventa' => 1.5,
            'categoria_id' => 1,
            'unidad_id' => 1,
        ]);
    }
}
