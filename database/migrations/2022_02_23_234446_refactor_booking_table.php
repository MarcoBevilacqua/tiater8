<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');

            $table->unsignedBigInteger('show_event_id');
            $table->string('booking_code', 8);
            $table->tinyInteger('number_of_places');
            $table->tinyInteger('place')->nullable(true);
            $table->tinyInteger('row')->nullable(true);
            $table->foreign('show_event_id')->references('id')->on('show_events');
            $table->foreign('customer_id')->references('id')->on('customers');
            
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
        Schema::drop('bookings');
    }
}
