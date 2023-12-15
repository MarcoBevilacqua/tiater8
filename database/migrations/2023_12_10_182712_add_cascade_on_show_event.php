<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddCascadeOnShowEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->dropForeign('bookings_show_event_id_foreign');
            $table->foreign('show_event_id')->references('id')->on('show_events')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->dropForeign('bookings_show_event_id_foreign');
            $table->foreign('show_event_id')->references('id')->on('show_events');
        });
    }
}
