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
            'precioventa' => 5,
            'categoria_id' => 1,
            'unidad_id' => 1,
        ]);

        DB::table('producto')->insert([
            'nombre' => 'Producto 2',
            'precioventa' => 5,
            'categoria_id' => 1,
            'unidad_id' => 1
        ]);
    }
}
