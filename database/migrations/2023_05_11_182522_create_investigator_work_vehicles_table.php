<?php

use App\Models\User;
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
        Schema::create('investigator_work_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('year');
            $table->string('make');
            $table->string('model');
            $table->string('picture')->nullable();
            $table->string('insurance_company');
            $table->string('policy_number');
            $table->date('expiration_date');
            $table->string('proof_of_insurance')->nullable()
                ->comment('File of proof of insurance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investigator_work_vehicles');
    }
};
