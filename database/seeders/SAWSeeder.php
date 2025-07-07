<?php

namespace Database\Seeders;

use App\Models\SAWCriteria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SAWSeeder extends Seeder
{
    public function run(): void
    {
        SAWCriteria::truncate();

        SAWCriteria::insert([
            [
                'name' => 'rating',
                'weight' => 0.1,
                'type' => 'benefit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'reviews',
                'weight' => 0.1,
                'type' => 'benefit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'distance',
                'weight' => 0.4,
                'type' => 'cost',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'promotion',
                'weight' => 0.4,
                'type' => 'cost',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
