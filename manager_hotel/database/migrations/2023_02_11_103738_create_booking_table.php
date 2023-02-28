<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('customer_id');
            $table->char('type_booking', 1);
            $table->dateTime('time_check_in');
            $table->dateTime('time_check_out');
            $table->integer('number_rooms');
            $table->text('feedback')->nullable();
            $table->dateTime('payment_date');
            $table->char('method_payment', 1);
            $table->char('status_payment', 1);
            $table->float('total_money');

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
        Schema::dropIfExists('booking');
    }
};
