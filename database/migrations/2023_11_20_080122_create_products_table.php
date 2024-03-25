<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('masp')->unique();
            $table->string('tensp');
            $table->string('chatlieu')->nullable();
            $table->string('donvi')->nulable();
            $table->string('kichthuoc')->nullable();
            $table->Integer('soluong')->nullable();
            $table->double('giaban')->nullable();
            $table->double('giamgia')->default(0);
            $table->json('hinhanh')->nullable();
            $table->string('mota')->nullable();
            $table->tinyInteger('spmoi')->nullable();
            $table->tinyInteger('spnoibat')->nullable();
            $table->Integer('categories_id')->unsigned()->nullable();
            $table->foreign('categories_id')->references('id')->on('categories')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('products');
    }
}
