<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_session', function (Blueprint $table) {
            $table->id();
            $table->string('zoom_id', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->enum('type', ['single', 'monthly', 'weekly'])->nullable();
            $table->integer('status')->nullable()->comment('1: publish, 0: draf');
            $table->integer('duration')->default(0);
            $table->text('join_link')->nullable();
            $table->text('image')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('date_interval', 255)->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('market_session');
    }
}
