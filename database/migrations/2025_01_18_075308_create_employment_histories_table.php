<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('companyName');
            $table->date('dateOfEmployment');
            $table->string('jobTitle');
            $table->string('supervisorName');
            $table->string('supervisorPhoneNumber');
            $table->string('jobResponsibilities');
            $table->string('reasonForLeaving')->nullable();
            $table->enum('ableToContactEmployer',['YES','NO']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employment_histories');
    }
};
