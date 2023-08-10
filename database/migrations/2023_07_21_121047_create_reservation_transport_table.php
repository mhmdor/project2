<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationTransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_transport', function (Blueprint $table) {
            $table->id();
            $table->integer('numberOfSeat');
            $table->unsignedBigInteger('transport_id');
            $table->foreign('transport_id')->references('id')
                ->on('transport')->onDelete('cascade');

            $table->unsignedBigInteger('reservation_id');
            $table->foreign('reservation_id')->references('id')
                ->on('reservation')->onDelete('cascade');
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
        Schema::dropIfExists('transports_reservations');
    }
}
