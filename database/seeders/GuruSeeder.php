<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Guru::create([
            'ID_Guru' => 'G001',
            'namaGuru' => 'Guru Default',
            'emel' => 'guru@example.com',
            'noTel' => '0123456789',
            'jawatan' => 'Guru',
            'kataLaluan' => 'password', // Pastikan hash jika perlu
            'diciptaOleh' => 'admin', // ID_Admin dari pentadbir
        ]);
    }
}
