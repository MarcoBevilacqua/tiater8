<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuotaToViewer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add quota field
        Schema::table('viewers', function(Blueprint $table){
            $table->enum("quota", array("S", "N"));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //remove quota field
        Schema::table('viewers', function(Blueprint $table){
           $table->removeColumn("quota");
        });
    }
}
