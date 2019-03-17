<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sale')->unsigned();
            $table->foreign('id_sale')->references('id')->on('sales')->onDelete('cascade');
            $table->integer('id_article')->unsigned();
            $table->foreign('id_article')->references('id')->on('article')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 11, 2); 
            $table->decimal('discount', 11, 2); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_detail');
    }
}
