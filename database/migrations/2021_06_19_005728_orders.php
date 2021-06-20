<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration
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
            $table->string('code_az')->nullable(); // mã đơn vận bên mình
            $table->string('code_customer')->nullable(); // mã khách hàng
            $table->string('code_b2b')->nullable(); // mã đơn khách hàng tạo bill
            $table->string('code_b2c')->nullable(); // mã khách hàng của khách hàng
            $table->timestamp('enter_date')->nullable(); // thời gian tạo đơn hàng lần đầu
            $table->timestamp('request_date')->nullable(); // thời gian yêu cầu phát
            $table->timestamp('confrim_date')->nullable(); //thời gian chuyển đơn hàng về máy chủ ( kích vào đây đồng nghĩa lên đơn tính phí)
            $table->timestamp('get_date')->nullable(); // thời gian lấy hàng 
            $table->string('phone_b2c')->nullable();  // điện thoại nhận hàng
            $table->string('name_from')->nullable();  // Nhận hàng từ người
            $table->string('code_product')->nullable(); // mã sản phẩm của sản phẩm khách hàng
            $table->string('full_name_b2c')->nullable(); // tên khách hàng
            $table->string('address')->nullable(); // địa chỉ số nhà cụ thể 
            $table->string('payments')->nullable(); // hình thức thanh toán
            $table->integer('city')->nullable(); // id của thành phố
            $table->string('ward')->nullable(); // id xã phường
            $table->string('district')->nullable(); // id quận huyện
            $table->string('weight')->nullable(); // tổng trọng lượng
            $table->integer('total')->nullable(); 
            $table->integer('packages')->nullable(); // tổng kiện hàng
            $table->integer('address_id')->nullable(); // địa chỉ lấy hàng
            $table->integer('collection_money')->nullable(); // tiền thu hộ cho đơn hàng
            $table->float('into_money')->nullable(); // tổng tiền tạm tính
            $table->string('type')->nullable(); // loại hình thức vận chuyển
            $table->integer('name_get')->nullable(); // id nhân viên đến đến lấy hàng
            $table->integer('name_confrim')->nullable(); // id nhân viên xác nhận lấy hàng
            $table->string('content')->nullable(); // nội dung yêu cầu thêm từ khách hàng
            $table->integer('status')->nullable(); // 1. Chờ xữ lý, 2. Yêu Cầu phát, 3. Chờ phát, 4 Đã phát thành công, 5. Hoàn lại đơn hàng
            $table->integer('is_deleted')->nullable(); // 1 đã xóa, 0 là chưa xóa
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
        Schema::dropIfExists('orders');
    }
}
