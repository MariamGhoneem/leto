<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\Stmt\Label;

class CreateCriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cries', function (Blueprint $table) {
            $table->id();
            $table->float('last_week');
            $table->float('sleep24');
            $table->float('sleep_avg');
            $table->float('last_wet');
            $table->integer('wet24');
            $table->float('wet_avg');
            $table->float('last_dirty');
            $table->integer('dirty24');
            $table->float('dirty_avg');
            $table->float('last_feed');
            $table->integer('feed24');
            $table->float('feed_avg');
            $table->float('normal_freq');
            $table->float('sleep_frq');
            $table->float('wet_freq');
            $table->float('dirty_freq');
            $table->float('food_freq');
            $table->float('normal_instance');
            $table->float('sleep_instance');
            $table->float('wet_instance');
            $table->float('dirty_instance');
            $table->float('food_instance');
            $table->json('Label');
            $table->timestamps();
            $table->foreignId('baby_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cries');
    }
}
