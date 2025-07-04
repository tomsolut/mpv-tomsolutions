<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::insert([
            [
                'name' => 'Erst-Validierung',
            ],
            [
                'name' => 'Re-Validierung',
            ],
            [
                'name' => 'Hygiene-Validierung',
            ],
            [
                'name' => 'Sicherheits-Check',
            ],
            [
                'name' => 'DGUV-Validierung',
            ],
        ]);
    }
}
