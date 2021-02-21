<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToMovimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimiento', function (Blueprint $table) {
            $table->decimal('efectivo', 10, 2)->nullable();
            $table->decimal('tarjeta', 10, 2)->nullable();
            $table->decimal('deposito', 10, 2)->nullable();
            $table->string('tipotarjeta')->nullable();
            $table->string('modalidadpago')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimiento', function (Blueprint $table) {
            $table->dropColumn('efectivo');
            $table->dropColumn('tarjeta');
            $table->dropColumn('deposito'); 
            $table->dropColumn('tipotarjeta');
            $table->dropColumn('modalidadpago'); 

        });
    }
}
