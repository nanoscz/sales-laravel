<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique();
            $table->string('description', 100)->nullable();
            $table->boolean('state')->default(1);
        });
        DB::table('roles')->insert(
            array(
                'id' => '1',
                'name' => 'admin',
                'description' => 'super user.'
            )
            );
        DB::table('roles')->insert(
            array(
                'id' => '2',
                'name' => 'user',
                'description' => ''
            )
            );
        DB::table('roles')->insert(
            array(
                'id' => '3',
                'name' => 'seller',
                'description' => 'super user.'
            )
            );
        DB::table('roles')->insert(
            array(
                'id' => '4',
                'name' => 'warehouse',
                'description' => 'super user.'
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
        Schema::dropIfExists('roles');
    }
}
