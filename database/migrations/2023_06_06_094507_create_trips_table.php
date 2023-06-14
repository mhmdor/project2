<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('descrption');
            $table->integer('price');
            $table->date('date');
            $table->double('beginLat');
            $table->double('beginLong');
            $table->double('endLat');
            $table->double('endLong');
            $table->integer('status');
            $table->unsignedBigInteger('tourism_id');
            $table->foreign('tourism_id')->references('id')
            ->on('tourisms')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('trips');
    }
}
