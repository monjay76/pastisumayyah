<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subjek;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed the 9 required subjects - only create if they don't exist
        $subjects = [
            ['nama_subjek' => 'Bahasa Malaysia'],
            ['nama_subjek' => 'Bahasa Inggeris'],
            ['nama_subjek' => 'Matematik'],
            ['nama_subjek' => 'Sains'],
            ['nama_subjek' => 'Jawi'],
            ['nama_subjek' => 'Peribadi Muslim'],
            ['nama_subjek' => 'Nurul Quran'],
            ['nama_subjek' => 'Arab'],
            ['nama_subjek' => 'Pra Tahfiz']
        ];

        foreach ($subjects as $subject) {
            // Check if subject already exists
            $existingSubject = Subjek::where('nama_subjek', $subject['nama_subjek'])->first();

            if (!$existingSubject) {
                Subjek::create($subject);
            }
        }
    }
}
