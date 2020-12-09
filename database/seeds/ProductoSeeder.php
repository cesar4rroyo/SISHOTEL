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
            'nombre' => 'Producto 1',
            'precioventa' => 2,
            'preciocompra' => 1,
            'categoria_id' => 1,
            'unidad_id' => 1
        ]);

        DB::table('producto')->insert([
            'nombre' => 'Producto 2',
            'precioventa' => 4,
            'preciocompra' => 1,
            'categoria_id' => 2,
            'unidad_id' => 2
        ]);
        DB::table('producto')->insert([
            'nombre' => 'Producto 3',
            'precioventa' => 5,
            'preciocompra' => 1,
            'categoria_id' => 2,
            'unidad_id' => 2
        ]);

        DB::table('producto')->insert([
            'nombre' => 'Producto 4',
            'precioventa' => 7,
            'preciocompra' => 5,
            'categoria_id' => 2,
            'unidad_id' => 2
        ]);
    }
}
