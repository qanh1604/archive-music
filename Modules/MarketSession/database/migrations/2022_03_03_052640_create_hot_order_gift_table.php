<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotOrderGiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hot_order_gift', function (Blueprint $table) {
            $table->id();
            $table->integer('market_id');
            $table->longText('gift');
            $table->longText('user');
            $table->longText('wheel');
            $table->integer('current_turn');
            $table->integer('max_turn');
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
        Schema::dropIfExists('hot_order_gift');
    }
}
