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
      Schema::table('investigator_licenses', function (Blueprint $table) {
          $table->string('insurance_file')->nullable()
              ->after('is_insurance')->comment('Insurance file');
          $table->string('bonded_file')->nullable()
              ->after('is_bonded')->comment('Bonded file');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('investigator_licenses', function (Blueprint $table) {
          $table->dropColumn([
              'insurance_file',
              'bonded_file'
          ]);
      });
    }
};
