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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('phoneNumber')->nullable();;
            $table->string('lastName');
            $table->string('middleName')->nullable();;
            $table->string('nationalId')->nullable();;
            $table->enum('maritalStatus', ['single','married','divorced'])->default('single');
            $table->date("dateOfBirth")->nullable();
            $table->string("currentAddress")->nullable();
            $table->enum("gender",['male','female'])->default("male");
            $table->boolean("isActive")->default(true);
            $table->integer("lengthService")->default(0);
            $table->string("medicalCertificate")->nullable();
            $table->unsignedBigInteger("line_manager_id")->default(0);
            $table->unsignedBigInteger("designation_id")->nullable();
            $table->integer("user_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
