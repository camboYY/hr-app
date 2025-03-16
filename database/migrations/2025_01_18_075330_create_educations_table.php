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
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->string('schoolName');
            $table->string('address');
            $table->enum('graduated',['YES', 'NO']);
            $table->enum('degreeEarned',['YES','NO']);
            $table->enum('typeOfDegree',['Certificate','Master', 'Bachelor', 'PHD', 'Post Doctoral', 'Diploma']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
