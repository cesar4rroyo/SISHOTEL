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
            $table->string('nombre', 20);
            $table->decimal('preciocompra', 10, 2);
            $table->decimal('precioventa', 10, 2);
            $table->unsignedInteger('categoria_id');
            $table->foreign('categoria_id', 'fk_producto_categoria')
                ->references('id')
                ->on('categoria')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('unidad_id');
            $table->foreign('unidad_id', 'fk_producto_unidad')
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
