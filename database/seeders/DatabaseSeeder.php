<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PrakerinProfile;
use App\Models\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin Account
        User::create([
            'name' => 'Administrator Prakerin',
            'email' => 'admin@prakerin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Seed Approved Student Account (Ridho)
        $student1 = User::create([
            'name' => 'Ridho Pratama',
            'email' => 'ridho@prakerin.com',
            'password' => Hash::make('password'),
            'role' => 'prakerin',
        ]);

        PrakerinProfile::create([
            'user_id' => $student1->id,
            'nisn' => '1234567890',
            'school' => 'SMK Negeri 1 Jakarta',
            'department' => 'Rekayasa Perangkat Lunak',
            'start_date' => '2026-07-01',
            'end_date' => '2026-10-01',
            'status' => 'approved',
        ]);

        // Seed some daily logs for Ridho
        Activity::create([
            'user_id' => $student1->id,
            'date' => '2026-07-01',
            'activity' => 'Melakukan pengenalan lingkungan kantor, pembagian mentor, dan briefing tugas magang.',
        ]);

        Activity::create([
            'user_id' => $student1->id,
            'date' => '2026-07-02',
            'activity' => 'Mempelajari dasar-dasar framework Laravel 11 dan instalasi lingkungan lokal (XAMPP).',
        ]);

        Activity::create([
            'user_id' => $student1->id,
            'date' => '2026-07-03',
            'activity' => 'Membuat rancangan ERD (Entity Relationship Diagram) untuk aplikasi monitoring jurnal magang.',
        ]);

        // 3. Seed Pending Student Account (Ahmad)
        $student2 = User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad@prakerin.com',
            'password' => Hash::make('password'),
            'role' => 'prakerin',
        ]);

        PrakerinProfile::create([
            'user_id' => $student2->id,
            'nisn' => '0987654321',
            'school' => 'SMK Negeri 2 Bandung',
            'department' => 'Teknik Komputer dan Jaringan',
            'start_date' => '2026-08-01',
            'end_date' => '2026-11-01',
            'status' => 'pending',
        ]);

        // 4. Seed Rejected Student Account (Siti)
        $student3 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@prakerin.com',
            'password' => Hash::make('password'),
            'role' => 'prakerin',
        ]);

        PrakerinProfile::create([
            'user_id' => $student3->id,
            'nisn' => '1122334455',
            'school' => 'SMK Negeri 4 Surabaya',
            'department' => 'Multimedia',
            'start_date' => '2026-07-10',
            'end_date' => '2026-10-10',
            'status' => 'rejected',
        ]);
    }
}
