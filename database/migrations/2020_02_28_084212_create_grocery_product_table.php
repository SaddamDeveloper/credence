<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroceryProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grocery_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_name', 191);
            $table->string('slug', 191);
            $table->integer('top_category_id');
            $table->integer('sub_category_id');
            $table->integer('brand_id')->nullable();
            $table->integer('discount');
            $table->integer('stock')->nullable();
            $table->text('desc');
            $table->double('price', 8, 2);
            $table->string('banner', 191);
            $table->integer('status')->default(1)->comment("1 = Active, 0 = Inactive");
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
        Schema::dropIfExists('grocery_product');
    }
}
