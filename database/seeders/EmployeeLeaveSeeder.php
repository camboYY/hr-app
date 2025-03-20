<?php

namespace Database\Seeders;

use App\Models\EmployeeLeave;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EmployeeLeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create(); // Manually creating a Faker instance

        for($i = 0; $i <20; $i++)
        {
            EmployeeLeave::firstOrCreate([
                'employee_id' => $i + 1,
                'leave_type_setting_id' => $i + 1,
                'leave_status_id'=> $i +1,
                "approver_id" => $i+1,
                "relief_id"=> $i+1,
                'fromDate' => $faker->dateTimeBetween('-1 year', 'now'),
                'toDate' => $faker->dateTimeBetween('-1 year', 'now'),
                'leave_option' => $faker->randomElement(["AFTERNOON","MORNING","NIGHT", "FULL"]),
                'reason' => $faker->paragraph(3),
            ]);
        }
    }
}
