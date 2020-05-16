<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSumToFloatInOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->float('total_sum', 8, 2)->change();
            $table->float('before_sum', 8, 2)->change();
            $table->float('prepay_sum', 8, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->integer('total_sum')->unsigned()->change();
            $table->integer('before_sum')->unsigned()->change();
            $table->integer('prepay_sum')->unsigned()->change();
        });
    }
}
