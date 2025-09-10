<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\TrendingTour;
use App\Models\TopDestination;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
{
    $destinations = Destination::select('id', 'name', 'image', 'slug')
        ->orderBy('name', 'asc')
        ->get();

    $trendingTours = TrendingTour::with('destination')
        ->latest()
        ->take(4)
        ->get();

    $topDestinations = TopDestination::with('destination')
        ->latest()
        ->take(3)
        ->get();

    $reviews = Review::with(['user','destination'])
        ->latest()
        ->take(6)
        ->get();

    return view('home', compact('destinations', 'trendingTours', 'topDestinations', 'reviews'));
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
