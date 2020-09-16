<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id');
            $table->integer('user_id');
            $table->integer('address_id');
            $table->string('payment_id')->nullable();
            $table->string('payment_order_id')->nullable();
            $table->string('payment_signature')->nullable();
            $table->string('amount')->nullable();
            $table->integer('payment_status')->nullable()->comment('1 = Failed, 2 = Paid');
            $table->integer('order_status')->default(1)->comment('1 = New Order, 2 = Out for Delivery, 3 = Delivered, 4 = Canceled');
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
        Schema::dropIfExists('order');
    }
}
