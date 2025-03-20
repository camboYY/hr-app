<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create(); // Manually creating a Faker instance

        for ($i =0; $i < 10; $i++)
        {
            Employee::firstOrCreate([
                'firstName' => $faker->firstName,
                'lastName' => $faker->lastName,
                'phoneNumber' => $faker->phoneNumber,
                'middleName' => $faker->randomLetter,
                'nationalId' => $faker->imageUrl(200, 200, 'people'),
                "maritalStatus" => $faker->randomElement(['Single', 'Married', 'Divorced', 'Widowed']),
                'dateOfBirth' => $faker->date(),
                'currentAddress' => $faker->address,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'isActive' => true,
                'lengthService' => $faker->randomNumber(2),
                'medicalCertificate' => $faker->randomElement(['Yes', 'No']),
                'line_manager_id' => $faker->numberBetween(0,10),
                'designation_id' => $faker->numberBetween(1,10),
                'user_id' => $faker->numberBetween(1,10),
            ]);
        }
    }
}
