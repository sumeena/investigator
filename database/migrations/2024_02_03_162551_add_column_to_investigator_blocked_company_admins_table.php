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
        Schema::table('investigator_blocked_company_admins', function (Blueprint $table) {
            $table->unsignedBigInteger('mail_sent')->after('company_admin_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investigator_blocked_company_admins', function (Blueprint $table) {
            $table->dropColumn('mail_sent');
        });
    }
};
