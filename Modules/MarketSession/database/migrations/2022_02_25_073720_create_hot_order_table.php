<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hot_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('market_id');
            $table->integer('seller_id');
            $table->integer('user_id');
            $table->text('product_name');
            $table->string('order_code', 255);
            $table->enum('payment_status', ['unpaid', 'paid']);
            $table->enum('delivery_status', ['pending', 'confirmed', 'picked_up', 'on_the_way', 'delivered', 'cancelled']);
            $table->string('tracking_code', 255)->nullable();
            $table->longText('shipping_address')->nullable();
            $table->integer('payment_status_viewed')->nullable();
            $table->integer('delivery_viewed')->nullable();
            $table->double('grand_total')->default(0);
            $table->dateTime('order_at');
            $table->dateTime('confirm_at')->nullable();
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
        Schema::dropIfExists('hot_orders');
    }
}
