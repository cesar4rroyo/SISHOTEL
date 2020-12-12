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
            $table->string('apellidos', 20)->nullable();
            $table->string('razonsocial')->nullable();
            $table->string('ruc')->nullable();
            $table->string('dni', 8)->nullable();
            $table->string('direccion', 100);
            $table->string('sexo')->nullable();
            $table->date('fechanacimiento')->nullable();
            $table->string('telefono');
            $table->string('observacion')->nullable();
            $table->unsignedInteger('nacionalidad_id')->nullable();
            $table->foreign('nacionalidad_id', 'fk_persona_nacionalidad')
                ->nullable()
                ->references('id')
                ->on('nacionalidad')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
