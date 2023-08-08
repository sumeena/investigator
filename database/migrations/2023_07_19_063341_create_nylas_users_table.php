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
            $table->foreignId('google_id')->nullable()->constrained('google_auth_users')->cascadeOnDelete();
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
