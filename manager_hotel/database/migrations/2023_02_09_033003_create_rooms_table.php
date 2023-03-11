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
        Schema::create('rooms', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('type_room_id');
            $table->char('status', 1)->default(1);
            $table->integer('number_people');
            $table->float('size')->nullable();
            $table->string('view', 200)->nullable();
            $table->integer('number_bed');
            $table->float('rent_per_night');
            $table->text('description')->nullable();

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
        Schema::dropIfExists('rooms');
    }
};
