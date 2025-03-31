<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (\App\Enums\RolesEnum::toArray() as $role) {
            \Spatie\Permission\Models\Role::firstOrCreate(['name' => $role]);
        }
    }
}
