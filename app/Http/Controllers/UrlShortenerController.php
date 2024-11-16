<?php

namespace App\Http\Controllers;

use App\Models\UrlShortener;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class UrlShortenerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('UrlShortener/Index', [
            'urls' => UrlShortener::paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('UrlShortener/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(['url' => 'required|url']);

        UrlShortener::create([
            'code' =>  UrlShortener::generateShortCode(),
            'original_url' => $validatedData['url']
        ]);

        return to_route('url_shortener.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $shortUrl = UrlShortener::where('code', $code)->firstOrFail();

        return Inertia::render('UrlShortener/Show', [
            'url_shortened' => $shortUrl,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $shortUrl = UrlShortener::findOrFail($id);
        $shortUrl->delete();
        return Redirect::back()->with('success', 'Url deleted successfully.');
    }
}
