<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_products', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->referrences('id')->on('products')->onUpdate('cascade')->onDelete('set null');
            $table->unsignedInteger('promotion_id');
            $table->foreign('promotion_id')->referrences('id')->on('promotions')->onUpdate('cascade')->onDelete('set null');
            $table->Integer('mucgiam');
            $table->Integer('soluongapdung');
            $table->Integer('soluongconlai');
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
        Schema::dropIfExists('promotion_products');
    }
}
