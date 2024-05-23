<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('energy_product_id');
            $table->double('volume', 8, 2);
            $table->unsignedBigInteger('buyer_id');
            $table->double('trade_price', 8, 2);
            $table->double('average_price', 8, 2);
            $table->double('admin_fee', 8, 2);
            $table->double('tax_rate', 8, 2);
            $table->foreign('energy_product_id')
                ->references('id')->on('energy_products')->onDelete('cascade');
            $table->foreign('buyer_id')
                ->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('trades');
    }
};
