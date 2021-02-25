<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('user_id')->nullable();
            $table->biginteger('order_id')->nullable();
            $table->double('amount')->nullable();
            $table->string('reasons')->nullable();
            $table->biginteger('ac_no')->nullable();
            $table->string('ac_name')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('branch')->nullable();
            $table->char('status')->comment('1=pending,2=paid')->nullable();
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
        Schema::dropIfExists('refund_infos');
    }
}
