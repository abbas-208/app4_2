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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('rememberToken', 100)->nullable();
            $table->unsignedBigInteger('zone_id');
            $table->boolean('isServiceManager')->default(false);
            $table->unsignedSmallInteger('trading_position');
            $table->double('balance', 8, 2)->default(0.0);
            $table->boolean('isActivated')->default(true);
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('post_code');
            
            $table->timestamps();

        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('zone_id')
            ->references('id')->on('zones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
