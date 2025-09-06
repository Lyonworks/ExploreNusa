<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
{
    // Semua destinasi (misal untuk search dropdown)
    $destinations = Destination::select('id', 'name', 'image', 'slug')
        ->orderBy('name', 'asc')
        ->get();

    // 6 review terbaru
    $reviews = Review::with(['user','destination'])
        ->latest()
        ->take(6)
        ->get();

    // 4 destinasi trending
    $trendingTours = Destination::latest()
        ->take(4)
        ->get();

    // 3 destinasi top berdasarkan rating
    $topDestinations = Destination::latest()
        ->take(3)
        ->get();

    return view('home', compact('destinations', 'reviews', 'trendingTours', 'topDestinations'));
}


    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'nullable|string|max:255',
        ]);

        $keyword = $request->keyword;

        $destinations = Destination::query()
            ->when($keyword, function ($query, $keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            })
            ->orderBy('name', 'asc')
            ->get();

        return view('search', compact('destinations', 'keyword'));
    }
}
