<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyIdToCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company', function (Blueprint $table) {

            if (Schema::hasColumn('company', 'created_company_id')) {
                $table->dropColumn('created_company_id');
            }
            $table->integer('created_company_id')->unsigned()->nullable()->after('created_user_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company', function (Blueprint $table) {
            if (Schema::hasColumn('company', 'created_company_id')) {
                $table->dropColumn('created_company_id');
            }
        });
    }
}
