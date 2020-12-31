<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasajeroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasajero', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('persona_id');
            $table->foreign('persona_id', 'fk_pasajero_persona')
                ->references('id')
                ->on('persona')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('movimiento_id');
            $table->foreign('movimiento_id', 'fk_pasajero_movimiento')
                ->references('id')
                ->on('movimiento')
                ->onDelete('restrict')
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
        Schema::dropIfExists('pasajero');
    }
}
