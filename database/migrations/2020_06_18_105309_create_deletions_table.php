<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeletionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deletions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('branch_id');
            $table->integer('status_id');
            $table->integer('user_id');
            $table->string('name')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deletions');
    }
}
