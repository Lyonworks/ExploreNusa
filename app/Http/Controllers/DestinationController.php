<?php

namespace App\Http\Controllers;

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

        // upload image
        if ($request->hasFile('image')) {
            $filename = Str::slug($request->name) . '.' . $request->image->extension();
            $request->image->storeAs('public/destinations', $filename);
            $validated['image'] = 'destinations/' . $filename;
        }

        Destination::create($validated);

        return redirect()->route('destinations.index')
            ->with('success', 'Destination created successfully!');
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

        return redirect()->route('destinations.index')
            ->with('success', 'Destination updated successfully!');
    }

    public function destroy($id)
    {
        $destination = Destination::findOrFail($id);

        if ($destination->image && Storage::exists('public/' . $destination->image)) {
            Storage::delete('public/' . $destination->image);
        }

        $destination->delete();

        return redirect()->route('destinations.index')
            ->with('success', 'Destination deleted successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | USER SECTION]
    |--------------------------------------------------------------------------
    */
    public function list()
    {
        $destinations = Destination::withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()
            ->get();

        return view('destinations.index', compact('destinations'));
    }

    public function show($id)
    {
        $destination = Destination::with(['facilities', 'reviews.user'])
            ->withAvg('reviews', 'rating')
            ->findOrFail($id);

        $reviews = $destination->reviews()->latest()->get();

        return view('destinations.show', compact('destination', 'reviews'));
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
