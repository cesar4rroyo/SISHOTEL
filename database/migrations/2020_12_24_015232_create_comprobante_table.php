<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprobanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobante', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipodocumento');
            $table->integer('numero');
            $table->date('fecha');
            $table->decimal('subtotal', 6, 4);
            $table->decimal('igv', 4, 4);
            $table->decimal('total', 6, 4);
            $table->string('comentario', 500)->nullable();
            $table->unsignedInteger('movimiento_id');
            $table->foreign('movimiento_id', 'fk_comprobante_movimiento')
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
        Schema::dropIfExists('comprobante');
    }
}