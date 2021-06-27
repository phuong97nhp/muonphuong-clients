<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Trackings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackings', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->string('address')->nullable(); // địa chỉ nhận hàng
            $table->string('city')->nullable(); // thành phố nhận hàng
            $table->string('ward')->nullable(); // phường nhận hàng
            $table->string('district')->unique(); // quận nhận hàng
            $table->string('phone')->nullable(); // số điện thoại người nhận
            $table->string('name_receiver')->nullable(); // tên người nhận
            $table->timestamp('date_receiver')->nullable(); // thời gian xác nhận hàng
            $table->string('note_customer')->nullable(); // khách hàng note khi nhận hàng
            $table->string('image')->nullable(); // khách hàng note khi nhận hàng
            $table->string('refund')->nullable(); // nguyên nhân hoàn đơn không nhận
            $table->integer('orders_are_in')->nullable(); // đờn hàng đang ở
            $table->integer('status')->nullable();
            $table->integer('is_deleted')->nullable();
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
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
        Schema::dropIfExists('trackings');
    }
}
