<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorShowModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shows', function (Blueprint $table) {
            $table->dropColumn(['full_price_qnt', 'half_price_qnt', 'total_qnt']);
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
        Schema::table('shows', function (Blueprint $table) {
            $table->tinyInteger('full_price_qnt');
            $table->tinyInteger('half_price_qnt');
            $table->tinyInteger('total_qnt');
            $table->dropTimestamps();
        });
    }
}
