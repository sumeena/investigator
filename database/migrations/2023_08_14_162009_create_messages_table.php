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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->integer('invitation_id')->nullable();
            $table->integer('from')->nullable();
            $table->integer('to')->nullable();
            $table->text('content')->nullable();
            $table->enum('is_read',['0','1'])->default('0');;
            $table->enum('is_delete',['0','1'])->default('0');
            $table->foreign('from')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('invitation_id')->references('id')->on('invitations')->onDelete('cascade');
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
        Schema::dropIfExists('messages');
    }
};
