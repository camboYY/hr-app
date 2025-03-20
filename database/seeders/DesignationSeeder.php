<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create(); // Manually creating a Faker instance
        // Seeding the designations table with some initial data.
        $designations = ['Manager', 'Senior Manager', 'Staff', 'Editor', 'Admin', 'Developer', 'Front-End','Senior Front-End','Back-End','Senior Back-End' ];

        foreach ($designations as $designation) {
            \App\Models\Designation::firstOrCreate(['name' => $designation,"responsibilities"=>$faker->sentence()]);
        }
    }
}
