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
        Schema::create('feed_backs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('goal_id');
            $table->unsignedBigInteger('employee_id');
            $table->string('feedback_title');
            $table->unsignedBigInteger('given_by_user_id');
            $table->date('given_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed_backs');
    }
};
