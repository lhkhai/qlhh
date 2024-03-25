<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseorderdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaseorderdetails', function (Blueprint $table) {
            $table->id();
           $table->Integer('order_id')->unsigned()->nullable();
           $table->foreign('order_id')->references('id')->on('purchaseorders');//->onDelete('set null')->onUpdate('cascade');
            $table->Integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products');//->onDelete('set null')->onUpdate('cascade');
            $table->float('dongia');
            $table->integer('soluong');
            $table->string('ghichu')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->integer('updated_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchaseorderdetails');
    }
}
