<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->unique();
            $table->string('code_customer')->nullable();
            $table->string('code_product')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->integer('address_id')->nullable(); // địa chỉ làm việc
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('ward')->nullable();
            $table->string('district')->nullable();
            $table->string('website')->nullable();
            $table->integer('prants_user_id')->nullable();
            $table->integer('level')->nullable();
            $table->integer('is_admin')->nullable();
            $table->integer('status')->nullable();
            $table->integer('is_deleted')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
