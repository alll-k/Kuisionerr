<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin', 'description' => 'Administrator - Mengelola sistem dan kuesioner']);
        Role::create(['name' => 'dosen', 'description' => 'Dosen - Mengisi kuesioner Tridharma']);
        Role::create(['name' => 'mahasiswa', 'description' => 'Mahasiswa - Mengisi kuesioner SDGs']);
    }
}
