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
            $table->dateTime('payment_date')->nullable();
            $table->char('method_payment', 1)->nullable();
            $table->char('status_payment', 1)->nullable();
            $table->char('status_booking', 1)->nullable();
            $table->integer('total_money')->nullable();
            $table->text('reason_cancel')->nullable();
            $table->dateTime('meal_time')->nullable();
            $table->text('note_booking_food')->nullable();
            $table->text('note_booking_room')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
