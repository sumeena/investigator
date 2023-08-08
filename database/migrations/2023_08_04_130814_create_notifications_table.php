<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->comment('Notification owner')
                ->constrained('users')->cascadeOnDelete();
            $table->foreignId('from_user_id')
                ->nullable()->comment('Notification sender')
                ->constrained('users')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('message')->nullable();
            $table->string('type')->nullable();
            $table->string('url')->nullable();
            $table->boolean('is_read')->default(false);
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
        Schema::dropIfExists('notifications');
    }
};
