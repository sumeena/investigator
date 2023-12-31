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
        Schema::create('settings', function (Blueprint $table) {
          $table->id();
          $table->string('user_id')->nullable();
          $table->string('assignment_invite')->nullable();
          $table->string('assignment_hired_or_closed')->nullable();
          $table->string('new_message')->nullable();
          $table->string('assignment_update')->nullable();
          $table->string('user_role')->nullable();
          $table->string('assignment_invite_message')->nullable();
          $table->string('assignment_hired_or_closed_message')->nullable();
          $table->string('new_message_on_message')->nullable();
          $table->string('assignment_update_message')->nullable();
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
        Schema::dropIfExists('settings');
    }
};
