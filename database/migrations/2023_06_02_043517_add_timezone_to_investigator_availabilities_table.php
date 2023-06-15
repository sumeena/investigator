<?php

use App\Models\Timezone;
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
        Schema::table('investigator_availabilities', function (Blueprint $table) {
            $table->foreignIdFor(Timezone::class)->nullable()->after('distance')
                ->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investigator_availabilities', function (Blueprint $table) {
            $table->dropForeign(['timezone_id']);
            $table->dropColumn(['timezone_id']);
        });
    }
};
