<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        DB::table('users')->insert([
            'name' => 'Ahmad Razali',
            'email' => 'admin@example.com',
            'type' => 'admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Parent Users
        $parentNames = [
            'Nurul Aini', 'Mohd Azlan', 'Fatimah Ismail',
            'Siti Zainab', 'Mohd Faiz', 'Zarina Hashim',
            'Rosli Hassan'
        ];

        foreach ($parentNames as $index => $name) {
            DB::table('users')->insert([
                'name' => $name,
                'email' => "parent{$index}@example.com",
                'type' => 'parent',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Student Users
        $studentNames = [
            'Aiman Hakim', 'Nurul Izzah', 'Syafiq Rahman',
            'Farah Nabila', 'Hafiz Zulkifli', 'Siti Aisyah',
            'Ahmad Shafiq', 'Nur Atiqah', 'Haziq Zulhilmi',
            'Nabila Hanani', 'Izwan Hafiz', 'Siti Zubaidah',
            'Muhammad Arif', 'Nur Sabrina', 'Amir Hafizi',
            'Siti Noor Azura', 'Faris Azman', 'Irfan Hakimi',
            'Syazana Aqilah', 'Ali Hanafiah', 'Fatin Farhana',
            'Zulhilmi Harith', 'Siti Nurhaliza', 'Mohd Faizal'
        ];

        foreach ($studentNames as $index => $name) {
            DB::table('users')->insert([
                'name' => $name,
                'email' => "student{$index}@example.com",
                'type' => 'student',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
