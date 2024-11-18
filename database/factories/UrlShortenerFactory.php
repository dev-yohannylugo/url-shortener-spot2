<?php

namespace Database\Factories;

use App\Models\UrlShortener;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UrlShortener>
 */
class UrlShortenerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' =>  UrlShortener::generateShortCode(),
            'original_url' => fake()->url(),
        ];
    }
}
