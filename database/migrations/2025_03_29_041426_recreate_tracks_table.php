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
        // Drop the table if it exists
        Schema::dropIfExists('tracks');

        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('goal_id');
            $table->enum('track_by',['Percent', 'Unit','Amount']);
            $table->decimal('meet_target_amount')->default(0);
            $table->decimal('exceed_target_amount')->default(0);
            $table->decimal('significant_exceed_target_amount')->default(0);
            $table->decimal('actual_archievement_amount')->default(0);
            $table->unsignedBigInteger('reviewed_by_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');

    }
};
