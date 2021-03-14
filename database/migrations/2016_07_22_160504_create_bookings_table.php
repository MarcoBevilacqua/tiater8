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
            $table->id();
            $table->unsignedBigInteger('view_id');        
            $table->enum('paid', array(0,1));
            $table->integer('full_price_qnt');
            $table->integer('half_price_qnt');
            $table->integer('total_qnt');
            $table->timestamp('booking_date');
            $table->string('place_code');
            $table->string('booking_code');
            $table->string('public_code', 10);
            $table->timestamps();

            $table->foreign('view_id')->references('id')->on('views');            
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
