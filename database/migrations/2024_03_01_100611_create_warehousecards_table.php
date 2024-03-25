<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousecardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehousecards', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('ngaythang'); //lấy ngày tháng từ hóa đơn nhập hoặc xuất
            $table->string('noinhan');      //Họ tên khách hàng hoặc kho
            $table->integer('product_id');
            $table->string('maphieunhap')->nullable();
            $table->string('maphieuxuat')->nullable();
            $table->integer('slnhap')->default(0);
            $table->integer('slxuat')->default(0);
            $table->integer('toncuoi')->default(0);
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
        Schema::dropIfExists('warehousecards');
    }
}
