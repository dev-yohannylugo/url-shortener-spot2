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
        UrlShortener::factory(8)->create();
        UrlShortener::factory()->create([
            'code' =>  UrlShortener::generateShortCode(),
            'original_url' => 'script>alert("¡Esto es un ataque!");</script><p>Contenido seguro</p>',
        ]);
        UrlShortener::factory()->create([
            'code' =>  'script>alert("¡Esto es otro ataque!");</script><p>Contenido seguro</p>',
            'original_url' => fake()->url(),
        ]);
    }
}
