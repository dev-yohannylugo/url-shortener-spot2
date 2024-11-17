<?php

namespace Database\Seeders;

use App\Models\UrlShortener;
use Illuminate\Database\Seeder;

class UrlShortenerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UrlShortener::factory(10)->create();
    }
}
