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
            $table->unsignedBigInteger('user_id');
            $table->string('qr_code');
            $table->string('description_image');
            $table->string('item_name');
            $table->integer('quantity');
            $table->string('remark')->nullable();
            $table->string('user_city');
            $table->double('item_price')->nullable();
            $table->double('total_amount')->nullable();
            $table->boolean('make_order')->nullable();
            $table->boolean('ordered')->nullable();
            $table->double('shippment_amount')->nullable();
            $table->boolean('order_arrived')->nullable();
            $table->boolean('rejected')->nullable();
            $table->string('rejected_reason')->nullable();
            $table->string('rejected_date')->nullable();
            $table->string('make_order_date')->nullable();
            $table->string('ordered_date')->nullable();
            $table->string('order_arrived_date')->nullable();
            $table->string('status')->nullable();
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
