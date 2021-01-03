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
            $table->decimal('subtotal', 10, 2);
            $table->decimal('igv', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('comentario', 500)->nullable();
            $table->unsignedInteger('movimiento_id')->nullable();
            $table->foreign('movimiento_id', 'fk_comprobante_movimiento')
                ->nullable()
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
