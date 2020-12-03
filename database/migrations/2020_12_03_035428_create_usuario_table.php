<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('login');
            $table->unsignedInteger('tipousuario_id');
            $table->foreign('tipousuario_id', 'fk_usuario_tipousuario')->nullable()->references('id')->on('tipousuario');
            $table->unsignedInteger('persona_id');
            $table->foreign('persona_id', 'fk_usuario_persona')->nullable()->references('id')->on('persona');
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
        Schema::dropIfExists('usuario');
    }
}
