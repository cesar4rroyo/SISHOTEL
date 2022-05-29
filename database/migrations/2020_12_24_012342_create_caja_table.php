<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha');
            $table->string('tipo', 50);
            $table->string('numero', 100);
            $table->decimal('total', 12, 2);
            $table->string('comentario', 500)->nullable();
            $table->unsignedInteger('concepto_id');
            $table->foreign('concepto_id', 'fk_caja_concepto')
                ->references('id')
                ->on('concepto')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('persona_id')->nullable();
            $table->foreign('persona_id', 'fk_caja_persona')
                ->nullable()
                ->references('id')
                ->on('persona')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('usuario_id');
            $table->foreign('usuario_id', 'fk_caja_usuario')
                ->references('id')
                ->on('usuario')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->unsignedInteger('movimiento_id')->nullable();
            $table->foreign('movimiento_id', 'fk_caja_movimiento')
                ->nullable()
                ->references('id')
                ->on('movimiento')
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
        Schema::dropIfExists('caja');
    }
}
