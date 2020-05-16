<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePriceToFloatInFinancePositions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finanse_position', function (Blueprint $table) {
            $table->float('price_before', 8, 2)->change();
            $table->float('price_after', 8, 2)->change();
            $table->float('price_total', 8, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finanse_position', function (Blueprint $table) {
            $table->integer('price_before')->unsigned()->change();
            $table->integer('price_after')->unsigned()->change();
            $table->integer('price_total')->unsigned()->change();
        });
    }
}
