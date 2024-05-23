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
        Schema::create('energy_histories', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('energy_id');
            $table->double('market_price', 8, 2);
            $table->foreign('energy_id')
            ->references('id')->on('energies')->onDelete('cascade');

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
        Schema::dropIfExists('energy_histories');
    }
};
