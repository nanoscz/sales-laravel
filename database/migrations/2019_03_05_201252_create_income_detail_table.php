<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomeDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_income')->unsigned();
            $table->foreign('id_income')->references('id')->on('income')->onDelete('cascade');
            $table->integer('id_article')->unsigned();
            $table->foreign('id_article')->references('id')->on('article')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 11, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('income_detail');
    }
}
