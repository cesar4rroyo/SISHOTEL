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
            $table->string('nombre', 50);
            $table->string('link', 100);
            $table->string('icono', 50)->nullable();
            $table->integer('orden')->default(0);
            $table->unsignedInteger('grupomenu_id')->default(0);
            $table->foreign('grupomenu_id', 'fk_opcionmenu_grupomenu')
                ->references('id')
                ->on('grupomenu')
                ->onDelete('cascade')
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
        Schema::dropIfExists('opcionmenu');
    }
}
