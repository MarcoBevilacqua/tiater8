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
            $table->integer("id", true);
            $table->integer("show_id")->unsigned;
            $table->dateTime("show_date");
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
