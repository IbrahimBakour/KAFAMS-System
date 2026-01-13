<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Define typical male and female names for students
          $male_names = ['Ahmad', 'Muhammad', 'Iskandar', 'Azman', 'Hakim', 'Syafiq', 'Faisal'];
          $female_names = ['Aisyah', 'Siti', 'Nurul', 'Farah', 'Ain', 'Hanna', 'Sofia'];

          // Define typical male and female parent names (for Malaysian context)
          $male_parent_names = ['Mohammad', 'Zulkifli', 'Abdullah', 'Razak', 'Hassan', 'Ismail', 'Jamal'];
          $female_parent_names = ['Rohana', 'Azizah', 'Salmah', 'Zahrah', 'Noraini', 'Fatimah', 'Marina'];

          // Create 24 parents (this will be used for "parent" type users)
          for ($i = 0; $i < 24; $i++) {
              $gender = $i % 2 == 0 ? 'Male' : 'Female';
              $parent_name = $gender == 'Male' ? fake()->randomElement($male_parent_names) : fake()->randomElement($female_parent_names);

              User::create([
                  'name' => $parent_name,
                  'email' => fake()->unique()->safeEmail(),
                  'type' => 'parent',
                  'password' => bcrypt('password'),
              ]);
          }

          // Fetch users with the type "student"
          $students = User::where('type', 'student')->get();
          $parents = User::where('type', 'parent')->get();

        // Define some Malaysian addresses (street names, cities, etc.)
        $malaysian_addresses = [
            'Jalan Kuching, 51200 Kuala Lumpur, Wilayah Persekutuan',
            'Jalan Tun Razak, 50400 Kuala Lumpur, Wilayah Persekutuan',
            'Jalan Ampang, 55000 Kuala Lumpur, Wilayah Persekutuan',
            'Jalan Petaling, 50000 Kuala Lumpur, Wilayah Persekutuan',
            'Jalan Johor, 81000 Johor Bahru, Johor',
            'Jalan Raja Laut, 50350 Kuala Lumpur, Wilayah Persekutuan',
            'Jalan Bukit Bintang, 55100 Kuala Lumpur, Wilayah Persekutuan',
            'Jalan Titiwangsa, 53200 Kuala Lumpur, Wilayah Persekutuan',
            'Jalan Mersing, 86000 Mersing, Johor',
            'Jalan Sg. Pencala, 56000 Kuala Lumpur, Wilayah Persekutuan'
        ];

          foreach ($students as $student) {
              // Determine gender based on the student's name
              $gender = 'Male';
              if (in_array(explode(' ', $student->name)[0], $female_names)) {
                  $gender = 'Female';
              }

              // Assign a random parent to the student
              $parent = $parents->random();  // Assign a random parent

              // Create a profile for each student
              Profile::create([
                  'user_id' => $student->id,
                  'student_name' => $student->name,
                  'gender' => $gender,
                  'address' => fake()->randomElement($malaysian_addresses),
                  'parent_name' => $parent->name, // Parent name from the parent user
                  'contact_no' => fake()->numerify('01########'),
              ]);
          }

    }
}
