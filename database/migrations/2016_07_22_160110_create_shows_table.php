<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shows', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string("title");
            $table->string("description");
            $table->integer("places");
            $table->float("full_price", 8, 2);
            $table->float("half_price", 8, 2);
            $table->string('image');
            $table->string('url');
            $table->tinyInteger('full_price_qnt');
            $table->tinyInteger('half_price_qnt');
            $table->tinyInteger('total_qnt');
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
        Schema::drop('shows');
    }
}
