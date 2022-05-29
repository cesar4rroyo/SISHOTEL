<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallecomprobanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallecomprobante', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad');
            $table->decimal('precioventa', 10, 2);
            $table->decimal('preciocompra', 10, 2);
            $table->string('comentario', 500)->nullable();
            $table->unsignedInteger('servicio_id')->nullable();
            $table->foreign('servicio_id', 'fk_detallecomprobante_servicios')
                ->nullable()
                ->references('id')
                ->on('servicios')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('producto_id')->nullable();
            $table->foreign('producto_id', 'fk_detallecomprobante_producto')
                ->nullable()
                ->references('id')
                ->on('producto')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('comprobante_id');
            $table->foreign('comprobante_id', 'fk_detallecomprobante_comprobante')
                ->references('id')
                ->on('comprobante')
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
        Schema::dropIfExists('detallecomprobante');
    }
}
