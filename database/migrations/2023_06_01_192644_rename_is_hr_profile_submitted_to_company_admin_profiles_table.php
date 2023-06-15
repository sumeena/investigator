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
        Schema::table('company_admin_profiles', function (Blueprint $table) {
            $table->renameColumn('is_hr_profile_submitted', 'is_company_profile_submitted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_admin_profiles', function (Blueprint $table) {
            $table->renameColumn('is_company_profile_submitted', 'is_hr_profile_submitted');
        });
    }
};
