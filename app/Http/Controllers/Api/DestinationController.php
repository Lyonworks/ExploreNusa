<?php
namespace App\Http\Controllers\Api;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    // GET /api/destinations  (list all with avg rating and facilities)
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 12);
        $data = Destination::with('facilities')
            ->withAvg('reviews as avg_rating', 'rating')
            ->latest()->paginate($perPage);
        return response()->json($data);
    }

    // GET /api/destinations/{id}
    public function show($id)
    {
        $destination = Destination::with(['facilities', 'reviews' => function($q){
            $q->latest();
        }, 'reviews.user:id,name'])
        ->withAvg('reviews as avg_rating', 'rating')
        ->findOrFail($id);

        return response()->json($destination);
    }

    // GET /api/destinations/search?keyword=
    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $perPage = (int) $request->get('per_page', 12);
        $query = Destination::query();
        if ($keyword) {
            $query->where(function($q) use ($keyword){
                $q->where('name','like',"%{$keyword}%")
                  ->orWhere('location','like',"%{$keyword}%")
                  ->orWhere('description','like',"%{$keyword}%");
            });
        }
        $data = $query->with('facilities')
                      ->withAvg('reviews as avg_rating','rating')
                      ->latest()->paginate($perPage);
        return response()->json($data);
    }
}
