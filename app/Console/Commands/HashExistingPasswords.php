<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pentadbir;
use App\Models\Guru;
use App\Models\IbuBapa;
use Illuminate\Support\Facades\Hash;

class HashExistingPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passwords:hash-existing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hash any existing plain text passwords in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking and hashing existing passwords...');

        // Check Pentadbir passwords
        $pentadbirCount = 0;
        $pentadbirs = Pentadbir::all();
        foreach ($pentadbirs as $user) {
            if ($user->kataLaluan && !str_starts_with($user->kataLaluan, '$2y$')) {
                // Password is not bcrypt hashed, hash it
                $user->update(['kataLaluan' => Hash::make($user->kataLaluan)]);
                $pentadbirCount++;
            }
        }

        // Check Guru passwords
        $guruCount = 0;
        $gurus = Guru::all();
        foreach ($gurus as $user) {
            if ($user->kataLaluan && !str_starts_with($user->kataLaluan, '$2y$')) {
                // Password is not bcrypt hashed, hash it
                $user->update(['kataLaluan' => Hash::make($user->kataLaluan)]);
                $guruCount++;
            }
        }

        // Check IbuBapa passwords
        $ibuBapaCount = 0;
        $ibuBapas = IbuBapa::all();
        foreach ($ibuBapas as $user) {
            if ($user->kataLaluan && !str_starts_with($user->kataLaluan, '$2y$')) {
                // Password is not bcrypt hashed, hash it
                $user->update(['kataLaluan' => Hash::make($user->kataLaluan)]);
                $ibuBapaCount++;
            }
        }

        $this->info("Password hashing completed:");
        $this->info("- Pentadbir: {$pentadbirCount} passwords hashed");
        $this->info("- Guru: {$guruCount} passwords hashed");
        $this->info("- Ibu Bapa: {$ibuBapaCount} passwords hashed");

        $total = $pentadbirCount + $guruCount + $ibuBapaCount;
        if ($total > 0) {
            $this->info("Total: {$total} passwords were hashed.");
        } else {
            $this->info("All passwords are already properly hashed.");
        }

        return Command::SUCCESS;
    }
}
