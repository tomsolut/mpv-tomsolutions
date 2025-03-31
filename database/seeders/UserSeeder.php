<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RolesEnum::toArray() as $role) {

            $user = new \App\Models\User();
            $user->name = str()->headline($role->value);
            $user->email = str()->snake($role->value) . '@example.com';
            $user->password = Hash::make('oktemBer2');
            $user->email_verified_at = now();
            $user->save();

            $user->assignRole($role->value);
        }
    }
}
