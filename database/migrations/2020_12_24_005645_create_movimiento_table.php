<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimiento', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fechaingreso')->nullable();
            $table->dateTime('fechasalida')->nullable();
            $table->decimal('dias', 4, 4)->nullable();
            $table->decimal('total', 6, 4)->nullable();
            $table->decimal('preciohabitacion', 8, 4)->nullable();
            $table->string('situacion', 50);
            $table->unsignedInteger('habitacion_id');
            $table->foreign('habitacion_id', 'fk_movimiento_habitacion')
                ->references('id')
                ->on('habitacion')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('reserva_id')->nullable();
            $table->foreign('reserva_id', 'fk_movimiento_reserva')
                ->nullable()
                ->references('id')
                ->on('reserva')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('persona_id');
            $table->foreign('persona_id', 'fk_movimiento_persona')
                ->references('id')
                ->on('persona')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('usuario_id');
            $table->foreign('usuario_id', 'fk_movimiento_usuario')
                ->references('id')
                ->on('usuario')
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
        Schema::dropIfExists('movimiento');
    }
}
