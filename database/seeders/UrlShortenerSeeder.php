<?php

namespace Database\Seeders;

use App\Models\UrlShortener;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UrlShortenerSeeder extends Seeder
{
    protected array $urls = [
        'https://www.youtube.com',
        'https://laravel.com/docs/11.x/seeding',
        'https://inertiajs.com',
        'https://tailwindui.com',
        'https://tailwindui.com/documentation',
        'https://www.youtube.com/watch?v=vyBoWlVeUBo',
        'https://www.youtube.com/watch?v=G76hDsKStj4',
        'https://www.youtube.com/watch?v=UwRMXjTyI1o',
        'https://laravel.com/docs/11.x/validation',
        'https://laravel.com/docs/11.x/controllers'
    ];


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->urls as $url) {
            UrlShortener::factory()->create([
                'code' => Str::random(8),
                'original_url' => $url
            ]);
        }
    }
}
