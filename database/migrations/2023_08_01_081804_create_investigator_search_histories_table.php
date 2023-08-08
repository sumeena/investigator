<?php

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
        Schema::create('investigator_search_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('Searcher/Searched By User')
                ->constrained('users')->onDelete('cascade');
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('country')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('surveillance')->nullable();
            $table->string('statements')->nullable();
            $table->string('misc')->nullable();
            $table->foreignId('license_id')->nullable()
                ->comment('License State from state table')
                ->constrained('states')->onDelete('cascade');
            $table->text('languages')->nullable()->comment('Languages ids from languages table');
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
        Schema::dropIfExists('investigator_search_histories');
    }
};
