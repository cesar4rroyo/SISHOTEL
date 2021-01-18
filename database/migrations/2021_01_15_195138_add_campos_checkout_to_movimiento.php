<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCamposCheckoutToMovimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimiento', function (Blueprint $table) {
            $table->decimal('early_checkin', 10, 2)->nullable();
            $table->decimal('late_checkout', 10, 2)->nullable();
            $table->decimal('day_use', 10, 2)->nullable();
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
            $table->dropColumn('early_checkin');
            $table->dropColumn('late_checkout');
            $table->dropColumn('day_use');
        });
    }
}
