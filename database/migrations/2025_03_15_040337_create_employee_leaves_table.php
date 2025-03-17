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
        Schema::create('employee_leaves', function (Blueprint $table) {
            $table->id();
            $table->integer("employee_id")->nullable();
            $table->integer("leave_type_setting_id")->nullable();
            $table->integer("leave_status_id")->nullable();
            $table->integer("approver_kd")->nullable();
            $table->string("reason")->nullable();
            $table->date("fromDate")->nullable();
            $table->date("toDate")->nullable();
            $table->enum("leave_option",["AFTERNOON","MORNING","NIGHT", "FULL"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_leaves');
    }
};
