<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderIdToIncome extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income', function (Blueprint $table) {
            if (Schema::hasColumn('income','order_id')) {
                //
            } else {
                $table->integer('order_id')->nullable()->after('from_user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('income', function (Blueprint $table) {
            if (Schema::hasColumn('income','order_id')) {
                $table->dropColumn('order_id');
            }
        });
    }
}
