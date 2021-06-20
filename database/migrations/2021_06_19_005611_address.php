<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Address extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->string('code_customer')->nullable();
            $table->string('name_address')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('ward')->nullable();
            $table->string('district')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('address_of')->nullable(); // post, customer
            $table->integer('status')->nullable();
            $table->integer('is_deleted')->nullable();
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
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
        Schema::dropIfExists('address');
    }
}
