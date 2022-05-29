<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleMovimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallemovimiento', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad');
            $table->decimal('precioventa', 10, 2);
            $table->decimal('preciocompra', 10, 2);
            $table->string('comentario', 500)->nullable();
            $table->date('fecha');
            $table->unsignedInteger('servicio_id')->nullable();
            $table->foreign('servicio_id', 'fk_detallemovimiento_servicios')
                ->nullable()
                ->references('id')
                ->on('servicios')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('producto_id')->nullable();
            $table->foreign('producto_id', 'fk_detallemovimiento_producto')
                ->nullable()
                ->references('id')
                ->on('producto')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('movimiento_id');
            $table->foreign('movimiento_id', 'fk_detallemovimiento_movimiento')
                ->references('id')
                ->on('movimiento')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detallemovimiento');
    }
}
