<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->integer('id_rol')->unsigned();

            $table->string('username');
            $table->string('password');
            $table->boolean('state')->default(1);
            $table->rememberToken();

            $table->foreign('id')->references('id')->on('person')->onDelete('cascade');
            $table->foreign('id_rol')->references('id')->on('roles');
        });
        DB::table('users')->insert(
            array(
                'id' => '1',
                'id_rol' => '1',
                'username' => 'admin',
                'password' => bcrypt('admin')
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
        Schema::dropIfExists('users');
    }
}
