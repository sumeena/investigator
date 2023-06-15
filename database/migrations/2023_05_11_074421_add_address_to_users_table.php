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
        Schema::table('users', function (Blueprint $table) {
          $table->string('address')->after('phone')->nullable();
          $table->string('address_1')->after('address')->nullable();
          $table->string('city')->after('address_1')->nullable();
          $table->integer('state_id')->after('city')->index()->nullable();
          $table->integer('country_id')->after('state_id')->index()->nullable();
          $table->integer('zipcode')->after('country_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('address');
          $table->dropColumn('address_1');
          $table->dropColumn('city');
          $table->dropColumn('state_id');
          $table->dropColumn('country_id');
          $table->dropColumn('zipcode');
        });
    }
};
