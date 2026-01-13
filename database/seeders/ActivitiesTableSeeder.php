<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quizzes = [
            // Adab Subject Questions
            [
                'subject' => 'Adab',
                'question' => 'What is the meaning of Adab in Islam?',
                'option_a' => 'Behavior and manners',
                'option_b' => 'Knowledge and wisdom',
                'option_c' => 'Physical strength',
                'option_d' => 'Religious obligations',
                'correct_option' => 'A',
            ],
            [
                'subject' => 'Adab',
                'question' => 'What is the Islamic etiquette for greeting?',
                'option_a' => 'Assalamualaikum',
                'option_b' => 'Good morning',
                'option_c' => 'Hello',
                'option_d' => 'Hi',
                'correct_option' => 'A',
            ],

            // Bahasa Arab Subject Questions
            [
                'subject' => 'Bahasa Arab',
                'question' => 'What is the Arabic word for "peace"?',
                'option_a' => 'Salam',
                'option_b' => 'Noor',
                'option_c' => 'Barakah',
                'option_d' => 'Fajr',
                'correct_option' => 'A',
            ],
            [
                'subject' => 'Bahasa Arab',
                'question' => 'How do you say "thank you" in Arabic?',
                'option_a' => 'Shukran',
                'option_b' => 'Jazakum Allah',
                'option_c' => 'Marhaban',
                'option_d' => 'Ahlan',
                'correct_option' => 'A',
            ],

            // Jawi Subject Questions
            [
                'subject' => 'Jawi',
                'question' => 'What is the correct Jawi script for the letter "A"?',
                'option_a' => 'ا',
                'option_b' => 'ب',
                'option_c' => 'ج',
                'option_d' => 'د',
                'correct_option' => 'A',
            ],
            [
                'subject' => 'Jawi',
                'question' => 'Which of the following is the correct Jawi for "Selamat"?',
                'option_a' => 'سلامت',
                'option_b' => 'سليم',
                'option_c' => 'سير',
                'option_d' => 'سافر',
                'correct_option' => 'A',
            ],
        ];

        // Insert data into the 'activities' table
        DB::table('activities')->insert($quizzes);
    }
}
