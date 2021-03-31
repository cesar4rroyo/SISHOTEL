<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallenotacreditoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallenotacredito', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('precioventa', 10, 2);
            $table->decimal('preciocompra', 10, 2);
            $table->integer('cantidad')->nullable();
            $table->string('comentario', 500)->nullable();
            $table->integer('producto_id')->unsigned()->nullable();
            $table->foreign('producto_id')->nullable()->references('id')->on('producto')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('servicio_id')->unsigned()->nullable();
            $table->foreign('servicio_id')->nullable()->references('id')->on('servicios')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('comprobante_id')->unsigned();
            $table->foreign('comprobante_id')->references('id')->on('comprobante')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('notacredito_id')->unsigned();
            $table->foreign('notacredito_id')->references('id')->on('notacredito')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('detallenotacredito');
    }
}
