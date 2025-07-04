<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Certificate;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Certificate::insert([
            [
                'name' => 'Brandschutz',
                'recall_period' => 365,
            ],
            [
                'name' => 'Hygiene',
                'recall_period' => 365,
            ],
            [
                'name' => 'Datenschutz',
                'recall_period' => 365,
            ],
        ]);
    }
}
