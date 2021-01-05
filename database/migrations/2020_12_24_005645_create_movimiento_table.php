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
            $table->decimal('descuento', 10, 2)->nullable();
            $table->dateTime('fechaingreso')->nullable();
            $table->dateTime('fechasalida')->nullable();
            $table->decimal('dias', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->decimal('preciohabitacion', 10, 4)->nullable();
            $table->string('situacion', 200);
            $table->string('comentario', 500)->nullable();
            $table->unsignedInteger('habitacion_id');
            $table->foreign('habitacion_id', 'fk_movimiento_habitacion')
                ->references('id')
                ->on('habitacion')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('tarjeta_id')->nullable();
            $table->foreign('tarjeta_id', 'fk_movimiento_tarjeta')
                ->nullable()
                ->references('id')
                ->on('tarjeta')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('reserva_id')->nullable();
            $table->foreign('reserva_id', 'fk_movimiento_reserva')
                ->nullable()
                ->references('id')
                ->on('reserva')
                ->onDelete('cascade')
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
