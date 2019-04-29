<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->bigIncrements('id');
    
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable()->default(null);

            $table->string('brand_color_primary')->nullable()->default(null);
            $table->string('brand_color_accent')->nullable()->default(null);
            $table->bigInteger('brand_logo_id')->unsigned()->nullable()->default(null);
            $table->foreign('brand_logo_id')->references('id')->on('images')->onDelete('set null');
            $table->bigInteger('brand_icon_id')->unsigned()->nullable()->default(null);
            $table->foreign('brand_icon_id')->references('id')->on('images')->onDelete('set null');

            $table->string('website')->nullable()->default(null);
            $table->string('contact_phone')->nullable()->default(null);
            $table->string('contact_email')->nullable()->default(null);
            
            $table->string('address_street');
            $table->string('address_city');
            $table->string('address_zip');
            $table->decimal('address_lat', 8, 6)->nullable()->default(null); // http://mysql.rjweb.org/doc.php/latlng
            $table->decimal('address_lon', 9, 6)->nullable()->default(null);

            $table->integer('parking_spots')->unsigned()->default(0);
            $table->integer('price_parking_spot')->unsigned()->default(0);
            $table->integer('price_meal_breakfast')->unsigned();
            $table->integer('price_meal_lunch')->unsigned();
            $table->integer('price_meal_dinner')->unsigned();

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
        Schema::dropIfExists('hotels');
    }
}
