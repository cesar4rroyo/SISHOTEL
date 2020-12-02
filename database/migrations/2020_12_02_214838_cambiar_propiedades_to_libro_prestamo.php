<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CambiarPropiedadesToLibroPrestamo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('libro_prestamo', function (Blueprint $table) {
            $table->string('prestado_a', 120)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('libro_prestamo', function (Blueprint $table) {
            $table->string('prestado_a', 100)->change();
        });
    }
}
