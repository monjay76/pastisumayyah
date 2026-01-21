<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdatePrestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first guru ID to use as default
        $guru = \App\Models\Guru::first();
        if ($guru) {
            \DB::table('prestasi')->whereNull('guru_id')->update([
                'guru_id' => $guru->ID_Guru,
                'ID_Guru' => $guru->ID_Guru,
            ]);
        }
    }
}
