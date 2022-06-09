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
            'nombres' => 'Varios',
            'ciudad' => 'Chiclayo',
            'dni'=> '88888888',
        ]);
    }
}
