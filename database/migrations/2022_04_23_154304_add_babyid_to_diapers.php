<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBabyidToDiapers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diapers', function (Blueprint $table) {
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
        Schema::table('diapers', function (Blueprint $table) {
            //
        });
    }
}
