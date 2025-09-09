<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * GET /api/destinations (list all with avg rating and facilities)
     */
    public function index(Request $request)
    {
        $perPage = max(1, (int) $request->get('per_page', 12));

        $data = Destination::with('facilities')
            ->withAvg('reviews', 'rating') // hasilnya jadi "reviews_avg_rating"
            ->latest()
            ->paginate($perPage);

        return response()->json($data);
    }

    /**
     * GET /api/destinations/{id}
     */
    public function show($id)
    {
        $destination = Destination::with([
                'facilities',
                'reviews' => function ($q) {
                    $q->latest();
                },
                'reviews.user:id,name'
            ])
            ->withAvg('reviews', 'rating')
            ->findOrFail($id);

        return response()->json($destination);
    }

    /**
     * GET /api/destinations/search?keyword=
     */
    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        $results = Destination::where('name', 'like', "%{$keyword}%")
            ->orWhere('location', 'like', "%{$keyword}%")
            ->get();

        return response()->json($results);
    }
}
