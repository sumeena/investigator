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
        Schema::create('investigator_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('driving_license')->nullable()
                ->comment('Driving License');
            $table->string('passport')->nullable()
                ->comment('Passport');
            $table->string('ssn')->nullable()
                ->comment('SSN');
            $table->string('birth_certificate')->nullable()
                ->comment('Birth Certificate');
            $table->string('form_19')->nullable()
                ->comment('Form 19');
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
        Schema::dropIfExists('investigator_documents');
    }
};
