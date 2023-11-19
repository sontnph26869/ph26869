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
            $table->string('email')->unique();
            $table->string('gauth_id')->nullable();
            $table->string('gauth_type')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();;
            $table->string('gender')->nullable();
            $table->string('avatar')->nullable();
            $table->string('status')->default(1);
            $table->string('gauth_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
