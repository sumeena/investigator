<?php

use App\Models\InvestigatorType;
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
        Schema::table('investigator_service_lines', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('investigation_type')->nullable()->after('user_id');
            $table->unsignedBigInteger('investigation_type_id')->after('user_id');
            $table->foreign('investigation_type_id')->references('id')->on('investigation_types')->onDelete('cascade');
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
            $table->dropColumn('investigation_type');
            $table->dropColumn('investigation_type_id');
        });
    }
};

