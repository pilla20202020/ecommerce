<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('phone');
            $table->string('email');
            $table->string('order_note')->nullable();
            $table->float('shipping_charge');
            $table->date('preferred_delivery_date')->nullable();
            $table->string('timeslot')->nullable();
            $table->float('total_amount');
            
            $table->enum('payment_method',['cash-on-delivery', 'esewa'])->default('cash-on-delivery');
            $table->enum('payment_status',['paid', 'unpaid'])->default('unpaid');
            $table->enum('status',['new', 'confirmed', 'processing', 'processed', 'pickup_ready', 'out_for_delivery', 'delivered', 'cancelled'])->default('new');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('SET NULL');
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
        Schema::dropIfExists('orders');
    }
}
