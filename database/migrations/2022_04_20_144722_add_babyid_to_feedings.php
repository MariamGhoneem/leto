<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBabyidToFeedings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedings', function (Blueprint $table) {
            $table->unsignedBigInteger('baby_id')->unsigned()->index()->nullable();
            $table->foreign('baby_id')->references('id')->on('babies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feedings', function (Blueprint $table) {
            //
        });
    }
}
