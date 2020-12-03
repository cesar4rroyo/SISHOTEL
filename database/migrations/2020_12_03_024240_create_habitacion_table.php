<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHabitacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habitacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero');
            $table->string('situacion', 200);
            $table->unsignedInteger('piso_id');
            $table->foreign('piso_id', 'fk_habitacion_piso')->references('id')->on('piso');
            $table->unsignedInteger('tipohabitacion_id');
            $table->foreign('tipohabitacion_id', 'fk_habitacion_tipohabitacion')->references('id')->on('tipohabitacion');
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
        Schema::dropIfExists('habitacion');
        // Schema::dropIfExists('habitacion', function (Blueprint $table) {
        //     $table->dropForeign('piso_id_foreign');
        //     $table->dropForeign('tipohabitacion_id_foreign');
        // });
    }
}
