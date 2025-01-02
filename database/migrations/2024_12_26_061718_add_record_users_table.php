<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         // Insert some stuff
        DB::table('users')->insert(
            array(
                'name' => 'Admin',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'email' => 'admin@domain.me',
                'email_verified_at' => now(),
        ));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
