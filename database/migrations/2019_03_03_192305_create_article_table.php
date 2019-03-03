<?php
 
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
 
class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_category')->unsigned();
            $table->string('code', 50)->nullable();
            $table->string('name', 100)->unique();
            $table->decimal('price', 11, 2);
            $table->integer('stock');
            $table->string('description', 256)->nullable();
            $table->boolean('state')->default(1);
            $table->timestamps();
 
            $table->foreign('id_category')->references('id')->on('category');
        });
    }
 
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
}
