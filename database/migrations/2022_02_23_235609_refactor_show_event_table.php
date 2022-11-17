<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorShowEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('show_events', function (Blueprint $table) {
            $table->dropColumn(['full_price_qnt',
            'half_price_qnt',
            'total_qnt',
            'full_price',
            'half_price']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('show_events', function (Blueprint $table) {
            $table->tinyInteger('full_price_qnt');
            $table->tinyInteger('half_price_qnt');
            $table->tinyInteger('full_price');
            $table->tinyInteger('half_price');
            $table->tinyInteger('total_qnt');
        });
    }
}
