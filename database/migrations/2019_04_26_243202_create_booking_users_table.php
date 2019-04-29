<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_users', function (Blueprint $table) {
            $table->bigInteger('booking_id')->unsigned();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('room_id')->unsigned();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');

            $table->datetime('date_check_in');
            $table->datetime('date_check_out');
            
            $table->boolean('is_main_booker')->default(false);
            $table->boolean('meal_breakfast')->default(false);
            $table->boolean('meal_lunch')->default(false);
            $table->boolean('meal_dinner')->default(false);
            $table->boolean('parking')->default(false);
            $table->text('special_wishes')->nullable()->default(null);

            $table->decimal('price_wishes', 19, 2)->nullable()->default(null);
            $table->decimal('price_parking', 19, 2)->nullable()->default(null);
            $table->decimal('price_meals', 19, 2)->nullable()->default(null);
            $table->decimal('price_room', 19, 2);
            $table->decimal('discount', 19, 2)->nullable()->default(null);
            $table->decimal('balance', 19, 2);

            $table->primary(['booking_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_users');
    }
}
