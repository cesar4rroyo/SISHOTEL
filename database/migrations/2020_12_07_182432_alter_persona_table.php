<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('persona', function (Blueprint $table) {
            $table->string('apellidos', 20)->nullable()->change();
            $table->string('razonsocial')->nullable()->change();
            $table->string('ruc', 12)->nullable()->change();
            $table->string('dni', 8)->nullable()->change();
            $table->string('direccion', 50)->change();
            $table->string('sexo')->nullable()->change();
            $table->date('fechanacimiento')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persona', function (Blueprint $table) {

            $table->string('apellidos', 20)->change();
            $table->string('razonsocial')->change();
            $table->string('ruc', 12)->change();
            $table->string('dni', 8)->change();
            $table->string('direccion', 20)->change();
            $table->string('sexo')->change();
            $table->date('fechanacimiento')->change();
        });
    }
}
