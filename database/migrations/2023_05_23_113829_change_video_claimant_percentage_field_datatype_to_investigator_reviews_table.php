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
        Schema::table('investigator_ratings_and_reviews', function (Blueprint $table) {
            $table->double('video_claimant_percentage')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investigator_ratings_and_reviews', function (Blueprint $table) {
            $table->integer('video_claimant_percentage')->change();
        });
    }
};
