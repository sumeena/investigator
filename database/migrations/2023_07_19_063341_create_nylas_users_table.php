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
        Schema::create('nylas_users', function (Blueprint $table) {
            $table->id();
            $table->integer('google_id')->nullable();
            $table->text('nylas_id')->nullable();
            $table->text('access_token')->nullable();
            $table->text('account_id')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('email_address')->nullable();
            $table->string('linked_at')->nullable();
            $table->string('name')->nullable();
            $table->string('object')->nullable();
            $table->string('organization_unit')->nullable();
            $table->string('provider')->nullable();
            $table->string('sync_state')->nullable();
            $table->timestamps();
            $table->foreign('google_id')->references('id')->on('google_auth_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nylas_users');
    }
};
