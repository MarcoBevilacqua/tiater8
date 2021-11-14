<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYearToSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->integer('year_from')->length(4);
            $table->integer('year_to')->length(4);
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->unique(['customer_id', 'year_from', 'year_to'], 'subscription_customer_id_year_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('year_from');
            $table->dropColumn('year_to');
        });
    }
}
