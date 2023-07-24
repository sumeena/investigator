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
        Schema::create('google_auth_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('access_token');
            $table->text('refresh_token');
            $table->string('token_type');
            $table->text('id_token');
            $table->string('scope');
            $table->string('expires_in');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('google_auth_users');
    }
};
