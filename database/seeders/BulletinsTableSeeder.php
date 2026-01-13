<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BulletinsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Sample bulletin data
         $bulletins = [
            [
                'bulletin_title' => 'Program Motivasi Pelajar KAFA',
                'bulletin_image' => 'motivation_program.jpg',
                'bulletin_desc' => 'Program motivasi pelajar KAFA bertujuan untuk meningkatkan semangat belajar dan pencapaian pelajar dalam semua subjek.',
                'bulletin_category' => 'Berita',
            ],
            [
                'bulletin_title' => 'Ceramah Agama Mingguan',
                'bulletin_image' => 'religious_talk.jpeg',
                'bulletin_desc' => 'Ceramah agama mingguan akan diadakan setiap Jumaat selepas solat Maghrib di surau sekolah.',
                'bulletin_category' => 'Berita',
            ],
            [
                'bulletin_title' => 'Gotong-Royong Perdana',
                'bulletin_image' => 'gotong_royong.jpg',
                'bulletin_desc' => 'Gotong-royong perdana akan diadakan pada hari Sabtu, melibatkan semua pelajar dan ibu bapa untuk membersihkan kawasan sekolah.',
                'bulletin_category' => 'Berita',
            ],
            [
                'bulletin_title' => 'Pengumuman Cuti Sekolah',
                'bulletin_image' => 'school_holiday.jpg',
                'bulletin_desc' => 'Cuti sekolah sempena Hari Raya Aidilfitri akan bermula pada 1 Syawal sehingga 7 Syawal.',
                'bulletin_category' => 'Pengumuman',
            ],
            [
                'bulletin_title' => 'Sukaneka Tahunan KAFA',
                'bulletin_image' => 'sports_day.jpg',
                'bulletin_desc' => 'Sukaneka tahunan akan diadakan pada minggu terakhir bulan ini. Semua pelajar digalakkan untuk menyertai aktiviti sukan.',
                'bulletin_category' => 'Berita',
            ],
        ];

        // Insert each bulletin into the database
        foreach ($bulletins as $bulletin) {
            DB::table('bulletins')->insert([
                'bulletin_title' => $bulletin['bulletin_title'],
                'bulletin_image' => $bulletin['bulletin_image'],
                'bulletin_desc' => $bulletin['bulletin_desc'],
                'bulletin_category' => $bulletin['bulletin_category'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
