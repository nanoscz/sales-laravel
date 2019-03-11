<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('type_document', 20)->nullable();
            $table->string('num_document', 20)->unique();
            $table->string('direction', 70)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->boolean('state')->default(1);
            $table->timestamps();
        });
        DB::table('person')->insert(
            array(
                'id' => '1',
                'name' => 'admin',
                'type_document' => 'CI',
                'num_document' => '1234567890',
                'direction' => '',
                'phone' => '1234567890',
                'email' => 'admin@admin.com'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person');
    }
}
