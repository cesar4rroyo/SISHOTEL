<?php

use App\Models\Nacionalidad;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NacionalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nacionalidad')->delete();
        $json = File::get("database/helpers/paises.json");
        $data = json_decode($json);
        foreach ($data as $item) {
            Nacionalidad::create(array(
                'nombre' => $item->nombre,
            ));
        }
    }
}
