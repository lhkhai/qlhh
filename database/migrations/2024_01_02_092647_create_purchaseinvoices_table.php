<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseinvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaseinvoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('maphieunhap');            
            $table->string('mahdnhap');
            $table->string('kyhieuhdnhap');
            $table->string('sohdnhap');
            $table->Date('ngayhdnhap');
            $table->tinyInteger('vat_hdnhap');
            $table->Date('ngaynhap');
            $table->string('ghichu_pn')->nullable();
            $table->string('maddh')->nullable();
            $table->Integer('staff_id')->unsigned()->nullable();
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('set null')->onUpdate('cascade');
            $table->Integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null')->onUpdate('cascade');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('purchaseinvoices');
    }
}
