<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoTable extends Migration
{

    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->decimal('preciocompra', 10, 2)->nullable();
            $table->decimal('precioventa', 10, 2)->nullable();
            $table->unsignedInteger('categoria_id')->nullable();
            $table->foreign('categoria_id', 'fk_producto_categoria')
                ->nullable()
                ->references('id')
                ->on('categoria')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('unidad_id')->nullable();
            $table->foreign('unidad_id', 'fk_producto_unidad')
                ->nullable()
                ->references('id')
                ->on('unidad')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('producto');
    }
}