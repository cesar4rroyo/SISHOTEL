<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserva', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha'); //fecha-entrada
            $table->dateTime('fechasalida')->nullable();
            $table->string('observacion', 200)->nullable();
            $table->string('situacion', 200)->nullable();
            $table->unsignedInteger('persona_id');
            $table->foreign('persona_id', 'fk_reserva_persona')
                ->references('id')
                ->on('persona')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('usuario_id');
            $table->foreign('usuario_id', 'fk_reserva_usuario')
                ->references('id')
                ->on('usuario')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('habitacion_id');
            $table->foreign('habitacion_id', 'fk_reserva_habitacion')
                ->references('id')
                ->on('habitacion')
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
        Schema::dropIfExists('reserva');
    }
}
