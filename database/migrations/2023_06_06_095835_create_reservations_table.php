<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
//            $table->unsignedBigInteger('trip_id');
//            $table->foreign('trip_id')->references('id')
//            ->on('trips')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')->references('id')
            ->on('profiles')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('total_price');
            $table->integer('vaild');
            $table->string('note');
            $table->integer('numOfClients');
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
        Schema::dropIfExists('reservations');
    }
}
