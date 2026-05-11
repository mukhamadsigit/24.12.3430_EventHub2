<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
                // 1. Akun Admin Utama
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@amikom.ac.id'],
            [
                'name' => 'Admin Amikom',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // 2. Insert Kategori Event
        $category = \App\Models\Category::create([
            'name' => 'Seminar IT',
            'slug' => 'seminar-it',
        ]);

        $category2 = \App\Models\Category::firstOrCreate([
            'name' => 'Entertaiment',
            'slug' => 'entertaiment',
        ]);

        // 3. Insert Sampel Events )
        \App\Models\Event::create([
            'category_id' => $category2->id,
            'title' => 'Jazz Night 2025',
            'description' => 'Nikmati malam yang indah dengan alunan musik.',
            'date' => '2026-05-10 19:00:00',
            'location' => 'Amikom Baru',
            'price' => 50000,
            'stock' => 100,
                        'poster_path' => 'assets/concert.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category->id,
            'title' => 'AI Summit & Expo 2026',
            'description' => 'Jelajahi tren terkini dalam bidang Artificial Intelligence',
            'date' => '2026-05-01 13:00:00',
            'location' => 'Ruang Cinema',
            'price' => 45000,
            'stock' => 150,
                        'poster_path' => 'assets/hackathon.png',
        ]);

        // 4. Tambahan Kategori (Dari Tugas) - SUDAH DITAMBAHKAN SLUG
        DB::table('categories')->insert([
            ['name' => 'Teknologi & Desain', 'slug' => 'teknologi-desain', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Olahraga & E-Sport', 'slug' => 'olahraga-e-sport', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Seminar & Karir', 'slug' => 'seminar-karir', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // 5. Tambahan 6 Jenis Kegiatan (Dari Tugas)
        DB::table('events')->insert([
            [
                'category_id' => 1, 
                'title' => 'UI/UX Masterclass: Designing for Gen Z',
                'description' => 'Workshop intensif merancang antarmuka aplikasi modern.',
                'date' => '2026-05-15 09:00:00',
                'location' => 'Ruang Citra 1',
                'price' => 0,
                'stock' => 50,
                                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
                'poster_path' => 'assets/workshop.png'
            ],
            [
                'category_id' => 1, 
                'title' => 'Laravel 11 Bootcamp',
                'description' => 'Belajar membuat API dan Web dengan framework Laravel.',
                'date' => '2026-05-20 09:00:00',
                'location' => 'Lab Komputer 2',
                'price' => 150000,
                'stock' => 40,
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
                'poster_path' => 'assets/hackathon.png'
            ],
            [
                'category_id' => 2, 
                'title' => 'E-Sport U-Champ: Mobile Legends',
                'description' => 'Turnamen e-sport antar universitas.',
                'date' => '2026-06-01 10:00:00',
                'location' => 'Student Center',
                'price' => 50000,
                'stock' => 32,
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
                'poster_path' => 'assets/hackathon.png'
            ],
            [
                'category_id' => 2, 
                'title' => 'Rektor Cup: Futsal Championship',
                'description' => 'Kompetisi futsal tahunan antar fakultas.',
                'date' => '2026-06-10 08:00:00',
                'location' => 'Lapangan Olahraga',
                'price' => 100000,
                'stock' => 16,
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
                'poster_path' => 'assets/concert.png'
            ],
            [
                'category_id' => 3, 
                'title' => 'Career Preparation Seminar 2026',
                'description' => 'Tips jitu lolos interview dan menyusun CV.',
                'date' => '2026-05-25 13:00:00',
                'location' => 'Ruang Seminar Utama',
                'price' => 25000,
                'stock' => 200,
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
                'poster_path' => 'assets/workshop.png'
            ],
            [
                'category_id' => 3, 
                'title' => 'Talkshow: Membangun Startup di Usia Muda',
                'description' => 'Sesi sharing bersama CEO startup ternama.',
                'date' => '2026-05-28 15:00:00',
                'location' => 'Auditorium',
                'price' => 35000,
                'stock' => 300,
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
                'poster_path' => 'assets/workshop.png'
            ],
        ]);
    }
}