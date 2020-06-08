<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedUserIdColToIncome extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income', function (Blueprint $table) {
            if (!Schema::hasColumn('income', 'user_id')) {
                $table->unsignedInteger('user_id')->nullable()->after('note')->comment('Создатель записи');

                // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
            if (Schema::hasColumn('income', 'user_id')) {
                $table->dropForeign('user_id');
                $table->dropColumn('user_id');
            }
        });
    }
}
