<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketSessionJoiner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_session_joiner', function (Blueprint $table) {
            $table->id();
            $table->integer('market_detail_id');
            $table->integer('user_id');
            $table->integer('wheel_turn')->default(0);
            $table->text('open_video')->nullable();
            $table->text('slider_video')->nullable();
            $table->dateTime('join_time');
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
        Schema::dropIfExists('market_session_joiner');
    }
}
