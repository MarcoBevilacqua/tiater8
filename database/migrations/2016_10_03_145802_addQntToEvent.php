<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQntToEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('show_events', function (Blueprint $table){
            $table->tinyInteger('full_price_qnt');
            $table->tinyInteger('half_price_qnt');
            $table->tinyInteger('total_qnt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('show_events', function (Blueprint $table){
            $table->removeColumn('full_price_qnt');
            $table->removeColumn('half_price_qnt');
            $table->removeColumn('total_qnt');
        });
    }
}
