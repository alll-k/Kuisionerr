<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles dan SDG goals first
        $this->call([
            RoleSeeder::class,
            SdgGoalSeeder::class,
        ]);

        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@unimus.ac.id',
            'password' => 'password',
            'role_id' => 1,
        ]);

        // Create dosen user
        User::factory()->create([
            'name' => 'Dosen User',
            'email' => 'dosen@unimus.ac.id',
            'password' => 'password',
            'role_id' => 2,
            'nisn_npm' => 'D001',
        ]);

        // Create mahasiswa user
        User::factory()->create([
            'name' => 'Mahasiswa User',
            'email' => 'mahasiswa@unimus.ac.id',
            'password' => 'password',
            'role_id' => 3,
            'nisn_npm' => 'M001',
        ]);
    }
}
