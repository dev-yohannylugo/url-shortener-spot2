<?php

namespace App\Http\Controllers;

use App\Models\UrlShortener;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cache;

class UrlShortenerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/url-shortener",
     *     tags={"Url-Shortener"},
     *     summary="Get a list of Urls Shortened",
     *     description="Get a list of Urls Shortened",
     *     @OA\Response(response=200, description="OK"),
     * )
     */
    public function index()
    {
        $urls = Cache::remember('urls', 86400, function () {
            return UrlShortener::all();
        });

        return Inertia::render('UrlShortener/Index', [
            'urls' => $urls
        ]);
    }

    /**
     * @OA\Get(
     *     path="/url-shortener/shorten",
     *     tags={"Url-Shortener"},
     *     summary="Get all params for create a Url Shortened",
     *     description="Get all params for create a Url Shortened",
     *     @OA\Response(response=200, description="OK"),
     * )
     */
    public function create()
    {
        return Inertia::render('UrlShortener/Create');
    }

    /**
     * @OA\Post(
     *     path="/url-shortener",
     *     tags={"Url-Shortener"},
     *     summary="Save a new Url Shortened",
     *     description="Save a new Url Shortened",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="url", type="string", description="Url to Shorten"),
     *                 example={"url": "https://www.youtube.com"}
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=302, description="Validation error")
     * )
     */

    public function store(Request $request)
    {
        $validatedData = $request->validate(['url' => 'required|url']);

        UrlShortener::create([
            'code' =>  UrlShortener::generateShortCode(),
            'original_url' => $validatedData['url']
        ]);
        Cache::forget('urls');

        return to_route('url_shortener.index');
    }

    /**
     * @OA\Get(
     *     path="/url-shortener/{code}",
     *     tags={"Url-Shortener"},
     *     summary="Get a Url Shortened for code",
     *     description="Get a Url Shortened for code",
     *     @OA\Parameter(
     *         description="Parameters",
     *         in="path",
     *         name="code",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="wiPQmlMc", summary="An string value."),
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Not Found")
     *
     * )
     */
    public function show($code)
    {
        $shortUrl = Cache::remember($code, 86400, function () use ($code) {
            return UrlShortener::where('code', $code)->firstOrFail();
        });

        return Inertia::render('UrlShortener/Show', [
            'url_shortened' => $shortUrl,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/url-shortener/{id}",
     *     tags={"Url-Shortener"},
     *     summary="Get a list of Urls Shortened",
     *     description="Get a list of Urls Shortened",
     *     @OA\Parameter(
     *         description="Parameters",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="123", summary="An int value."),
     *     ),
     *     @OA\Response(response=201, description="OK"),
     *     @OA\Response(response=404, description="Not Found")
     *
     * )
     */
    public function destroy($id)
    {
        $shortUrl = UrlShortener::findOrFail($id);
        $shortUrl->delete();
        Cache::forget($shortUrl->code);
        Cache::forget('urls');

        return Redirect::back()->with('success', 'Url deleted successfully.');
    }
}
