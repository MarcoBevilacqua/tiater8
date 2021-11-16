<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable(true);
            $table->string('subscription_email')->nullable(false)->default("");
            $table->integer('status')->nullable(false)->default(0);
            $table->dateTime('expires_at')->nullable(true);
            $table->string('token')->nullable(false)->default('');
            $table->integer('contact_type')->nullable(true);
            $table->integer('activity')->nullable(true);
            $table->integer('year_from')->length(4);
            $table->integer('year_to')->length(4);

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
        Schema::dropIfExists('subscriptions');
    }
}
