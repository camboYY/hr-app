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
        Schema::create('leave_statuses', function (Blueprint $table) {
            $table->timestamps();
            $table->id();
            $table->string("reason")->nullable();
            $table->date("date");
            $table->enum("status",["APPROVED", "REJECTED","PENDING","CANCELLED"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_statuses');
    }
};
