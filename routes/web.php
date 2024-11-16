<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UrlShortenerController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


 Route::get('/', function () {
    return redirect(route('dashboard'));
 });

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/url-shortener', [UrlShortenerController::class, 'index'])->name('url_shortener.index');
    Route::get('/url-shortener/shorten', [UrlShortenerController::class, 'create'])->name('url_shortener.create');
    Route::post('/url-shortener/shorten', [UrlShortenerController::class, 'store'])->name('url_shortener.store');
    Route::delete('/url-shortener/{id}', [UrlShortenerController::class, 'destroy'])->name('url_shortener.destroy');
    Route::get('/url-shortener/{code}', [UrlShortenerController::class, 'show'])->name('url_shortener.show');
});

require __DIR__.'/auth.php';
