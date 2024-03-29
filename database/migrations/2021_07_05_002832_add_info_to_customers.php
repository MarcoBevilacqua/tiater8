<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoToCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('city')->nullable(true);
            $table->date('birth')->nullable(true);
            $table->string('resident')->nullable(true);
            $table->string('address')->nullable(true);
            $table->string('postal_code')->nullable(true);
            $table->string('province')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->removeColumn([
                'city',
                'birth',
                'resident',
                'address',
                'postal_code',
                'province',
                'contact_type',
                'activity'
            ]);
        });
    }
}
