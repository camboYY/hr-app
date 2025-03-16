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
        Schema::create('leave_type_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('leave_type',["ANNUAL_LEAVE","SICK_LEAVE","SPECIAL_LEAVE","MARRIAGE_LEAVE","MANDATORY_LEAVE","MATERNITY_LEAVE"]);
            $table->double('leave_balance')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_type_settings');
    }
};
