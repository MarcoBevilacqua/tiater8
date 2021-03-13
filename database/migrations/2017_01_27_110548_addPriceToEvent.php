<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriceToEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('show_events', function(Blueprint $table){

            $table->tinyInteger('full_price');
            $table->tinyInteger('half_price');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('show_events', function(Blueprint $table){

            $table->removeColumn('full_price');
            $table->removeColumn('half_price');

        });
    }
}
