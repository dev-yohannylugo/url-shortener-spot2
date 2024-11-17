<?php


use App\Models\User;
use App\Models\UrlShortener;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia as Assert;

test('User not logged cannot acess to page Urls Shortened', function () {
    $response = $this->get('/url-shortener');
    $response->assertRedirect('/login');
});

test('User logged can acess to page Urls Shortened', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $this->get('/url-shortener')->assertStatus(200);
});

test('Get a list of shortened urls', function () {
    $user = User::factory()->create();
    $urls = UrlShortener::factory()->create(['code' => Str::random(8), 'original_url' => 'https://youtube.com']);
    $this->actingAs($user);
    $response = $this->get('/url-shortener');
    $response->assertStatus(200);

    $response->assertInertia(
        fn(Assert $page) => $page
            ->component('UrlShortener/Index')
            ->has('urls', 1)
    );
});

test('Render the create view', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->get('/url-shortener/shorten');
    $response->assertStatus(200);
    $response->assertInertia(fn(Assert $page) => $page->component('UrlShortener/Create'));
});

test('Store a new shortened url', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $data = ['url' => 'https://youtube.com'];
    $response = $this->post('/url-shortener/shorten', $data);
    $response->assertRedirect(route('url_shortener.index'));
});

test('Throws validation error for invalid url', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->get('/url-shortener/invalid_url');
    $response->assertStatus(404);
});

test('Show a shortened url for a valid code', function () {
    $user = User::factory()->create();
    $shortUrl = UrlShortener::factory()->create(['code' => Str::random(8), 'original_url' => 'https://youtube.com']);
    $this->actingAs($user);
    $response = $this->get("/url-shortener/$shortUrl->code");
    $response->assertStatus(200);

    $response->assertInertia(fn(Assert $page) => $page
        ->component('UrlShortener/Show')
        ->has(
            'url_shortened',
            fn(Assert $page) => $page
                ->where('id', $shortUrl->id)
                ->where('code', $shortUrl->code)
                ->where('original_url', $shortUrl->original_url)
                ->has('created_at')
                ->has('updated_at')
                ->has('deleted_at')
        ));
});

test('Return 404 for invalid id', function () {
    $user = User::factory()->create();
    $shortUrl = UrlShortener::factory()->create(['code' => Str::random(8), 'original_url' => 'https://youtube.com']);
    $this->actingAs($user);
    $response = $this->delete("/url-shortener/$shortUrl->id");
    $response->assertStatus(302);
});


test('Returns 404 for invalid id', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->get('/url-shortener/22222');
    $response->assertStatus(404);
});

test('Delete Url Sortened for id', function () {
    $user = User::factory()->create();
    $shortUrl = UrlShortener::factory()->create(['code' => Str::random(8), 'original_url' => 'https://youtube.com']);
    $this->actingAs($user);
    $response = $this->delete("/url-shortener/$shortUrl->id");
    $response->assertStatus(302);
});
