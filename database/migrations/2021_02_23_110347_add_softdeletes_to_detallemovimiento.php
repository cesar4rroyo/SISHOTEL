<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftdeletesToDetallemovimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detallemovimiento', function (Blueprint $table) {
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
        Schema::table('detallemovimiento', function (Blueprint $table) {
            $table->dropSoftDeletes();            
            
        });
    }
}
