<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeletionPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deletion_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('deletion_id');
            $table->integer('company_id');
            $table->integer('branch_id');
            $table->integer('product_id');
            $table->integer('position_id');
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
        Schema::dropIfExists('deletion_positions');
    }
}
