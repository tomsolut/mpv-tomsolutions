<?php

namespace Database\Seeders;

use Database\Seeders\DeviceTypeSeeder;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $this->call([
           RoleSeeder::class,
           UserSeeder::class,
           DeviceTypeSeeder::class,
           DeviceSeeder::class,
           ServiceSeeder::class,
           CertificateSeeder::class,
       ]);
    }
}
