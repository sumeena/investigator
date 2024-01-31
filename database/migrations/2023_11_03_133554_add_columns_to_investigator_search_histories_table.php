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
        Schema::table('investigator_search_histories', function (Blueprint $table) {
            $table->string('distance')->after('availability')->nullable();
            $table->string('withInternalInvestigator')->after('availability')->nullable();
            $table->string('withExternalInvestigator')->after('availability')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investigator_search_histories', function (Blueprint $table) {
            $table->dropColumn('distance');
            $table->dropColumn('withInternalInvestigator');
            $table->dropColumn('withExternalInvestigator');
        });
    }
};
