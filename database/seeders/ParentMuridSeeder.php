<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\IbuBapa;
use App\Models\Murid;
use App\Models\ParentMurid;
use Faker\Factory as Faker;

class ParentMuridSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('ms_MY'); // Malaysian locale

        // Clear existing data to avoid duplicates
        // Temporarily disable foreign key checks to allow truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Truncate related tables first to maintain referential integrity
        ParentMurid::truncate();
        Murid::truncate();
        IbuBapa::truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Generate parent data
        $parents = [];
        $parentNames = [
            ['Ahmad', 'Bin', 'Ali'],
            ['Siti', 'Binti', 'Hassan'],
            ['Mohammad', 'Bin', 'Yusof'],
            ['Noraini', 'Binti', 'Rahman'],
            ['Abdullah', 'Bin', 'Khalid'],
            ['Fatimah', 'Binti', 'Zakaria'],
            ['Rahman', 'Bin', 'Ismail'],
            ['Aishah', 'Binti', 'Omar'],
            ['Zainal', 'Bin', 'Abidin'],
            ['Hajjah', 'Binti', 'Salleh']
        ];

        foreach ($parentNames as $index => $nameParts) {
            $parents[] = IbuBapa::create([
                'ID_Parent' => 'P' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'namaParent' => implode(' ', $nameParts),
                'emel' => strtolower($nameParts[0]) . ($index + 1) . '@gmail.com',
                'noTel' => '01' . $faker->numberBetween(2, 9) . '-' . $faker->numberBetween(1000000, 9999999),
                'kataLaluan' => 'password123',
                'diciptaOleh' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Generate student data
        $students = [];
        $studentNames = [
            ['Muhammad', 'Amirul'],
            ['Nur', 'Aina'],
            ['Ahmad', 'Danial'],
            ['Siti', 'Nursyahirah'],
            ['Mohammad', 'Hafiz'],
            ['Nor', 'Sophia'],
            ['Ali', 'Imran'],
            ['Aisyah', 'Nadirah'],
            ['Zain', 'Adam'],
            ['Hana', 'Balqis'],
            ['Irfan', 'Hakim'],
            ['Liyana', 'Batrisyia'],
            ['Harith', 'Aiman'],
            ['Nadia', 'Amani'],
            ['Firdaus', 'Iqbal'],
            ['Sarah', 'Aqilah'],
            ['Rayyan', 'Haziq'],
            ['Mia', 'Sofia'],
            ['Ethan', 'Zaki'],
            ['Amira', 'Dania']
        ];

        $classes = ['1A', '1B', '2A', '2B', '3A', '3B', '4A', '4B'];

        foreach ($studentNames as $index => $nameParts) {
            $students[] = Murid::create([
                'MyKidID' => 'M' . str_pad($index + 1, 6, '0', STR_PAD_LEFT),
                'namaMurid' => implode(' ', $nameParts),
                'kelas' => $classes[array_rand($classes)],
                'tarikhLahir' => $faker->dateTimeBetween('-12 years', '-5 years')->format('Y-m-d'),
                'alamat' => $faker->streetAddress . ', ' . $faker->city . ', ' . $faker->state . ', Malaysia',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Create parent-child relationships
        // Scenario 1: Single parent relationships
        ParentMurid::create([
            'ID_Parent' => $parents[0]->ID_Parent, // Ahmad Bin Ali
            'MyKidID' => $students[0]->MyKidID,    // Muhammad Amirul
            'created_at' => now(),
            'updated_at' => now()
        ]);

        ParentMurid::create([
            'ID_Parent' => $parents[1]->ID_Parent, // Siti Binti Hassan
            'MyKidID' => $students[1]->MyKidID,    // Nur Aina
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Scenario 2: Both parents relationships (mother and father)
        ParentMurid::create([
            'ID_Parent' => $parents[2]->ID_Parent, // Mohammad Bin Yusof
            'MyKidID' => $students[2]->MyKidID,    // Ahmad Danial
            'created_at' => now(),
            'updated_at' => now()
        ]);

        ParentMurid::create([
            'ID_Parent' => $parents[3]->ID_Parent, // Noraini Binti Rahman
            'MyKidID' => $students[2]->MyKidID,    // Ahmad Danial (same child)
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Scenario 3: Multiple children with same parent
        ParentMurid::create([
            'ID_Parent' => $parents[4]->ID_Parent, // Abdullah Bin Khalid
            'MyKidID' => $students[3]->MyKidID,    // Siti Nursyahirah
            'created_at' => now(),
            'updated_at' => now()
        ]);

        ParentMurid::create([
            'ID_Parent' => $parents[4]->ID_Parent, // Abdullah Bin Khalid
            'MyKidID' => $students[4]->MyKidID,    // Mohammad Hafiz
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Scenario 4: Complex family relationships
        ParentMurid::create([
            'ID_Parent' => $parents[5]->ID_Parent, // Fatimah Binti Zakaria
            'MyKidID' => $students[5]->MyKidID,    // Nor Sophia
            'created_at' => now(),
            'updated_at' => now()
        ]);

        ParentMurid::create([
            'ID_Parent' => $parents[6]->ID_Parent, // Rahman Bin Ismail
            'MyKidID' => $students[5]->MyKidID,    // Nor Sophia
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Additional relationships for testing
        foreach ($students as $studentIndex => $student) {
            if ($studentIndex >= 6) { // Skip already assigned students
                $parentIndex = rand(0, count($parents) - 1);
                ParentMurid::create([
                    'ID_Parent' => $parents[$parentIndex]->ID_Parent,
                    'MyKidID' => $student->MyKidID,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // 30% chance of having a second parent
                if (rand(0, 100) < 30 && count($parents) > 1) {
                    $secondParentIndex = rand(0, count($parents) - 1);
                    while ($secondParentIndex === $parentIndex) {
                        $secondParentIndex = rand(0, count($parents) - 1);
                    }

                    ParentMurid::create([
                        'ID_Parent' => $parents[$secondParentIndex]->ID_Parent,
                        'MyKidID' => $student->MyKidID,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }

        $this->command->info('Parent-Child relationships seeded successfully!');
        $this->command->info('- Created ' . count($parents) . ' parents');
        $this->command->info('- Created ' . count($students) . ' students');
        $this->command->info('- Created ' . ParentMurid::count() . ' parent-child relationships');
    }
}
