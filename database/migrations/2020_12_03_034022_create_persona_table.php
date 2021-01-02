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
            $table->string('nombres', 50);
            $table->integer('edad')->nullable();
            $table->string('apellidos', 50)->nullable();
            $table->string('razonsocial')->nullable();
            $table->string('ruc')->nullable();
            $table->string('dni')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('direccion', 100)->nullable();
            $table->string('sexo')->nullable();
            $table->date('fechanacimiento')->nullable();
            $table->string('telefono')->nullable();
            $table->string('observacion', 500)->nullable();
            $table->string('email', 50)->nullable();
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
