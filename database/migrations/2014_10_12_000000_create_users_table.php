<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->dateTime('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('login_count')->unsigned()->default(0);
            $table->dateTime('last_login')->nullable();
            $table->string('profile_photo')->nullable();
            $table->date('birthday')->nullable();
            $table->char('sex', 1)->nullable();
            $table->boolean('tutorial')->default(0);
            $table->rememberToken();
            $table->timestamps('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
