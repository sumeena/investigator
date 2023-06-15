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
        Schema::table('investigator_service_lines', function (Blueprint $table) {
            $table->double('hourly_rate')->nullable()->change();
            $table->double('travel_rate')->nullable()->change();
            $table->double('milage_rate')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investigator_service_lines', function (Blueprint $table) {
            $table->integer('hourly_rate')->nullable()->change();
            $table->integer('travel_rate')->nullable()->change();
            $table->integer('milage_rate')->nullable()->change();
        });
    }
};
