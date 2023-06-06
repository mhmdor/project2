<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->integer('mobile')->unique();
            $table->integer('valid')->default(0);
            $table->integer('role');
            $table->integer('lName')->nullable();
            $table->date('birth')->nullable();
            $table->string('gender')->nullable();
            $table->double('lat')->nullable();
            $table->double('long')->nullable();
            $table->longText('descrption')->nullable();
            $table->string('license')->nullable();
            $table->integer('category_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
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
