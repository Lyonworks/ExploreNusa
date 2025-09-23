<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class DestinationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN SECTION (CRUD)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $destinations = Destination::latest()->paginate(10);
        return view('admin.destinations', compact('destinations'));
    }

    public function create()
    {
        return view('admin.destinations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $filename = Str::slug($request->name) . '.' . $request->image->extension();
            $request->image->storeAs('public/destinations', $filename);
            $validated['image'] = 'destinations/' . $filename;
        }

        $destination = Destination::create($validated);

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'model' => 'Destination',
            'model_id' => $destination->id,
            'description' => "Created destination: {$destination->name}"
        ]);

        return redirect('/admin/destinations')->with('success', 'Destination created successfully!');
    }

    public function edit($id)
    {
        $destination = Destination::findOrFail($id);
        return view('admin.destinations.edit', compact('destination'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $destination = Destination::findOrFail($id);

        if ($request->hasFile('image')) {
            $filename = Str::slug($request->name) . '.' . $request->image->extension();
            $request->image->storeAs('public/destinations', $filename);
            $validated['image'] = 'destinations/' . $filename;
        }

        $destination->update($validated);

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model' => 'Destination',
            'model_id' => $destination->id,
            'description' => "Updated destination: {$destination->name}"
        ]);

        return redirect('/admin/destinations')->with('success', 'Destination updated successfully!');
    }

    public function destroy($id)
    {
        $destination = Destination::findOrFail($id);

        if ($destination->image && Storage::exists('public/' . $destination->image)) {
            Storage::delete('public/' . $destination->image);
        }

        $destination->delete();

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'model' => 'Destination',
            'model_id' => $destination->id,
            'description' => "Deleted destination: {$destination->name}"
        ]);

        return redirect('/admin/destinations')->with('success', 'Destination deleted successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | USER SECTION
    |--------------------------------------------------------------------------
    */
    public function list(Request $request   )
    {
        $query = Destination::query();

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        $destinations = $query->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()
            ->get();

        return view('destinations.index', compact('destinations'));
    }

    public function show($id)
    {
        $destination = Destination::with('facilities','reviews.user')->findOrFail($id);

        // daftar destinasi untuk dropdown di form review
        $destinations = Destination::all();

        // ambil reviews (sudah eager-loaded di atas, tapi tetap ambil collection)
        $reviews = $destination->reviews()->with('user')->latest()->get();

        return view('destinations.show', compact('destination', 'reviews', 'destinations'));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        $results = Destination::where('name', 'like', "%{$keyword}%")
            ->orWhere('location', 'like', "%{$keyword}%")
            ->get();

        return response()->json($results);
    }

}
