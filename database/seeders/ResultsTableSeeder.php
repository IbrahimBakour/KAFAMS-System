<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResultsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // List of KAFA subjects
        $subjects = [  'Al-Quran',
        'Akidah',
        'Ibadah',
        'Sirah',
        'Adab',
        'Bahasa Arab',
        'Jawi dan Khat',
        'Tahfiz al-Quran'];

        // Types of assessments
        $assessments = ['Peperiksaan Awal Tahun 2024', 'Peperiksaan Pertengahan Tahun 2024'];

        // Get all students from the `users` table
        $students = DB::table('users')->where('type', 'student')->get();

        foreach ($students as $student) {
            foreach ($assessments as $assessment) {
                foreach ($subjects as $subject) {
                    // Generate random marks between 40 and 100
                    $marks = rand(40, 100);

                    DB::table('results')->insert([
                        'student_name' => $student->name,
                        'student_class' => 'KAFA 5', // Assuming all students are in KAFA 5; adjust as needed
                        'assessment_subject' => $subject,
                        'assessment_type' => $assessment,
                        'marks' => $marks,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
