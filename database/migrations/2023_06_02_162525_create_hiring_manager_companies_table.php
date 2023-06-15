<?php

use App\Models\CompanyAdminProfile;
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
        Schema::create('hiring_manager_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_admin_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('hiring_manager_id')->constrained('users')->cascadeOnDelete();
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
        Schema::dropIfExists('hiring_manager_companies');
    }
};
