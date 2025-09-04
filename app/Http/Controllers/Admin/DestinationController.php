<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    // GET /api/admin/destinations
    public function index()
    {
        $destinations = Destination::with('facilities')
            ->withAvg('reviews as avg_rating', 'rating')
            ->latest()->paginate(20);
        return response()->json($destinations);
    }

    // POST /api/admin/destinations
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'slug' => 'nullable|string|max:190|unique:destinations,slug',
        ]);
        if (empty($data['slug'])) $data['slug'] = Str::slug($data['name'].'-'.uniqid());
        $destination = Destination::create($data);
        return response()->json(['message' => 'Destinasi dibuat','data' => $destination], 201);
    }

    // POST /api/admin/destinations/{id}
    public function update(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);
        $data = $request->validate([
            'name' => 'sometimes|string|max:150',
            'location' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'slug' => "nullable|string|max:190|unique:destinations,slug,{$id}",
        ]);
        $destination->update($data);
        return response()->json(['message' => 'Destinasi diupdate','data' => $destination]);
    }

    // GET /api/admin/destinations/delete/{id}  (as requested)
    // Also support DELETE /api/admin/destinations/{id}
    public function destroy($id)
    {
        $destination = Destination::findOrFail($id);
        $destination->delete();
        return response()->json(['message' => 'Destinasi dihapus']);
    }
}
