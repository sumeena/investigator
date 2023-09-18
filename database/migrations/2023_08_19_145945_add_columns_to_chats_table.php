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
        Schema::table('chats', function (Blueprint $table) {
            $table->integer('company_admin_id')->after('assignment_id')->nullable();
            $table->integer('investigator_id')->after('company_admin_id')->nullable();
            $table->json('is_read')->after('investigator_id')->nullable();
            $table->foreign('company_admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('investigator_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn('company_admin_id');
            $table->dropColumn('investigator_id');
            $table->dropColumn('is_read');
        });
    }
};
