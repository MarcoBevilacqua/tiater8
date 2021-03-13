<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('viewer_id')->unsigned;
            $table->integer('show_id')->unsigned;
            $table->integer('event_id')->unsigned;
            $table->enum('paid', array(0,1));
            $table->integer('full_price_qnt');
            $table->integer('half_price_qnt');
            $table->integer('total_qnt');
            $table->timestamp('booking_date');
            $table->string('place_code');
            $table->string('booking_code');
            $table->timestamps();

            $table->foreign('viewer_id')->references('id')->on('viewers');
            $table->foreign('show_id')->references('id')->on('shows');
            $table->foreign('event_id')->references('id')->on('show_events')->onDelete('cascade');
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
