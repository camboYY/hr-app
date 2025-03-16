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
        Schema::create('employment_forms', function (Blueprint $table) {
            $table->id();
            $table->string('fullName');
            $table->string('city');
            $table->string('state');
            $table->string('zipCode');
            $table->string('email');
            $table->string('phone');
            $table->date('startWorkingDate');
            $table->string('workingLocation');
            $table->string('announcementReachedToCandidateBy');
            $table->string('disclaimer')->default('<COMPANY NAME> is an equal opportunity employer. All applicants will be considered for employment without attention to race, color, religion, sex, sexual orientation, gender identity, national origin, veteran, or disability status.');
            $table->string('acknowledge')->default('I acknowledge that the answers given within this employment application are accurate and complete to the best of my knowledge. I understand that any false or misleading information can be used to justify refusing to hire me or for dismissal if I am hired.');
            $table->boolean('agreed')->default(false);
            $table->string('printedNameOfApplicant');
            $table->string('employmentUrl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employment_forms');
    }
};
