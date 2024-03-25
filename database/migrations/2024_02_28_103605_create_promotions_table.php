<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mactkm');
            $table->string('tenctkm');
            $table->datetime('ngaybd');
            $table->datetime('ngaykt');
            $table->unsignedInteger('promotiontype_id');
            $table->foreign('promotiontype_id')->references('id')->on('promotiontypes');
            $table->unsignedInteger('promotion_invoice_id');
            $table->foreign('promotion_invoice_id')->references('id')->on('promotion_invoices');
            $table->boolean('trangthai');
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
        Schema::dropIfExists('promotions');
    }
}
