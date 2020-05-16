<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSumInOrderPosition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_position', function (Blueprint $table) {
            $table->float('pos_cost', 8, 2)->change();
            $table->float('total_sum', 8, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_position', function (Blueprint $table) {
            $table->integer('pos_cost')->unsigned()->change();
            $table->integer('total_sum')->unsigned()->change();
        });
    }
}
