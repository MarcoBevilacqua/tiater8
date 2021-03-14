<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('show_events', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger("show_id");
            $table->dateTime("show_date");
            $table->tinyInteger('full_price_qnt');
            $table->tinyInteger('half_price_qnt');
            $table->tinyInteger('total_qnt');
            $table->tinyInteger('full_price');
            $table->tinyInteger('half_price');

            $table->timestamps();

            $table->foreign("show_id")->references("id")->on("shows")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('show_events');
    }
}
