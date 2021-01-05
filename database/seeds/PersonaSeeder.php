<?php

use App\Models\Persona;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('persona')->insert([
            'nombres' => 'Santiago Ronald',
            'apellidos' => 'Rodas Ipanaque',
            'dni' => '45841576',
            'telefono' => '974866028',

        ]);
        DB::table('persona')->insert([
            'nombres' => 'Richard',
            'apellidos' => 'Serrano Bautista',
            'dni' => '75020436',
            'telefono' => '986783159',


        ]);
        DB::table('persona')->insert([
            'nombres' => 'Juan Eduardo',
            'apellidos' => 'Bazan Guerrero',
            'dni' => '45841576',
            'telefono' => '932827302',

        ]);
        DB::table('persona')->insert([
            'nombres' => 'Carlos Enrique',
            'apellidos' => 'Mauriola Huamanchumo',
            'dni' => '75767335',
            'telefono' => '939067566',

        ]);
    }
}
