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
        Schema::table('chat_user', function (Blueprint $table) {
            $table->integer('media_id')->after('content')->nullable();
            $table->string('type')->after('media_id')->nullable();
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chat_user', function (Blueprint $table) {
            $table->dropColumn('file_type');
            $table->dropColumn('type');
        });
    }
};
