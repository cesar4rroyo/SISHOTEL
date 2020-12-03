<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres', 20);
            $table->string('apellidos', 20);
            $table->string('razonsocial');
            $table->string('ruc', 12);
            $table->string('dni', 8);
            $table->string('direccion', 20);
            $table->string('sexo');
            $table->date('fechanacimiento');
            $table->string('telefono');
            $table->string('observacion');
            $table->unsignedInteger('nacionalidad_id');
            $table->foreign('nacionalidad_id', 'fk_persona_nacionalidad')->nullable()->references('id')->on('nacionalidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona');
    }
}
