<?php

namespace Database\Seeders;

use App\Models\LeaveTypeSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LeaveTypeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create(); // Manually creating a Faker instance

        for($i=0; $i<10; $i++)
        {
            LeaveTypeSetting::firstOrCreate([
                'leave_type' => $faker->randomElement(['ANNUAL_LEAVE', 'SICK_LEAVE', 'SPECIAL_LEAVE', 'MARRIAGE_LEAVE', 'MANDATORY_LEAVE', 'MATERNITY_LEAVE', 'COMPENSATE_LEAVE']),
                'leave_balance' => $faker->randomFloat(2, 0, 100),
            ]);
        }
    }
}
