<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccesoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acceso', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tipousuario_id');
            $table->foreign('tipousuario_id', 'fk_acceso_tipousuario')
                ->references('id')
                ->on('tipousuario')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('opcionmenu_id');
            $table->foreign('opcionmenu_id', 'fk_acceso_opcionmenu')
                ->references('id')
                ->on('opcionmenu')
                ->onDelete('cascade')
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
        Schema::dropIfExists('acceso');
    }
}
