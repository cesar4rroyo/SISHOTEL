<?php

use App\Models\Servicios;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //id = 1 
        DB::table('servicios')->insert([
            'nombre' => 'Servicio de Hotel',
        ]);

        DB::table('servicios')->insert([
            'nombre' => 'Desayuno Incluido',
            'precio' => 1,
        ]);
    }
}
