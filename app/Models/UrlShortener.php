<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class UrlShortener extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['code','original_url'];

    public static function generateShortCode() {
        do {
            $code = Str::random(8);
        } while (UrlShortener::where('code', $code)->exists());

        return $code;
    }
}
