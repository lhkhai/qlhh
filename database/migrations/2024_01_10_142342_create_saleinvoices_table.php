<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleinvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saleinvoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('maphieuxuat');            
            $table->string('mahdxuat')->nullable();            
            $table->Date('ngayxuat');
            $table->double('tongthanhtien');
            $table->string('ghichu_px')->nullable();
            $table->string('order_id')->nullable();
            $table->Integer('staff_id')->unsigned()->nullable();
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('set null')->onUpdate('cascade');
            $table->Integer('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null')->onUpdate('cascade');
            $table->Integer('promotion_id')->nullable();
            $table->foreign('promotion_id')->references('id')->on('promotion')->onDelete('set nul')->onUpdate('cascade');
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
        Schema::dropIfExists('saleinvoices');
    }
}
