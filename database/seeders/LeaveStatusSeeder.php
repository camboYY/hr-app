<?php

namespace Database\Seeders;

use App\Models\LeaveStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LeaveStatusSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create(); // Manually creating a Faker instance

        // Seeding the leave_statuses table with some initial data.
        $leaveStatuses = ['PENDING', 'APPROVED', 'REJECTED', "CANCELLED"];
        foreach ($leaveStatuses as $leaveStatus) {
            LeaveStatus::firstOrCreate(
                [
                'status' => $leaveStatus, 'date'=>$faker->date(),
                "reason"=>$faker->sentence()
            ]);
        }
    }
}
