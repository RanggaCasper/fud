<?php

namespace Database\Seeders;

use App\Models\AdsType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdsType::updateOrCreate(
            ['type' => 'carousel'], // kriteria pencarian
            [
                'name' => 'Carousel Ad',
                'base_price' => 50000,
            ]
        );

        AdsType::updateOrCreate(
            ['type' => 'restaurant'],
            [
                'name' => 'Restaurant Ad',
                'base_price' => 30000,
            ]
        );
    }
}
