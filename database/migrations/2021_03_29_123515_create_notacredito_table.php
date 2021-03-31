<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotacreditoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notacredito', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero');
            $table->string('motivo');
            $table->dateTime('fecha');
            $table->string('observacion')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('igv', 10, 2)->nullable();
            $table->string('situacion')->nullable();
            $table->integer('comprobante_id')->unsigned();
            $table->foreign('comprobante_id')->references('id')->on('comprobante')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('concepto_id')->unsigned();
            $table->foreign('concepto_id')->references('id')->on('concepto')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('usuario')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('persona_id')->unsigned();
            $table->foreign('persona_id')->references('id')->on('persona')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('notacredito');
    }
}
