<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_prefix')->nullable()->default(null);
            $table->string('name_first');
            $table->string('name_last');
            $table->string('email')->unique();
            $table->string('phone')->nullable()->default(null);
            $table->string('password');
            $table->bigInteger('image_id')->unsigned()->nullable()->default(null);
            $table->foreign('image_id')->references('id')->on('images')->onDelete('set null');
            $table->timestamp('email_verified_at')->nullable()->default(null);
            $table->datetime('login_last')->nullable()->default(null);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('images', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable()->default(null);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::dropIfExists('users');
    }
}
