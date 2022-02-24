<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketSessionSeller extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_session_seller', function (Blueprint $table) {
            $table->id();
            $table->integer('market_id');
            $table->integer('seller_id');
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
        Schema::dropIfExists('market_session_seller');
    }
}
