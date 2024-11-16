<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UrlShortener>
 */
class UrlShortenerFactory extends Factory
{
    protected static ?string $url;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->unique(),
            'original_url' => static::$url ??= fake()->slug(),
        ];
    }
}
