<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedUserIdColToOutcome extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outcome', function (Blueprint $table) {
            if (!Schema::hasColumn('outcome', 'user_id')) {
                $table->unsignedInteger('user_id')->nullable()->after('is_retail')->comment('Создатель записи');

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
        Schema::table('outcome', function (Blueprint $table) {
            if (Schema::hasColumn('outcome', 'user_id')) {
                $table->dropForeign('user_id');
                $table->dropColumn('user_id');
            }
        });
    }
}
