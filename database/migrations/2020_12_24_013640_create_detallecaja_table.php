<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallecajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallecaja', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad');
            $table->decimal('precioventa', 10, 2);
            $table->decimal('preciocompra', 10, 2);
            $table->string('comentario', 500)->nullable();
            $table->unsignedInteger('servicio_id')->nullable();
            $table->foreign('servicio_id', 'fk_detallecaja_servicios')
                ->nullable()
                ->references('id')
                ->on('servicios')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('producto_id')->nullable();
            $table->foreign('producto_id', 'fk_detallecaja_producto')
                ->nullable()
                ->references('id')
                ->on('producto')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('caja_id')->nullable();
            $table->foreign('caja_id', 'fk_detallecaja_caja')
                ->nullable()
                ->references('id')
                ->on('caja')
                ->onDelete('restrict')
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
        Schema::dropIfExists('detallecaja');
    }
}
