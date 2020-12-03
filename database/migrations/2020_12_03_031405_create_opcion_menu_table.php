<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpcionMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opcionmenu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 20);
            $table->string('link', 100);
            $table->string('icono', 50);
            $table->integer('orden');
            $table->unsignedInteger('grupomenu_id');
            $table->foreign('grupomenu_id', 'fk_opcionmenu_grupomenu')->references('id')->on('grupomenu');
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
        Schema::dropIfExists('opcionmenu');
    }
}
