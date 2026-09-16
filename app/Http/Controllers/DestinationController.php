<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    private function storageKey(?string $image): ?string
    {
        $image = trim((string) $image);

        if ($image === '') {
            return null;
        }

        $path = parse_url($image, PHP_URL_PATH) ?: $image;
        $path = trim($path, '/');
        $bucket = trim((string) config('filesystems.disks.s3.bucket'), '/');

        if ($bucket !== '') {
            $publicPrefix = "storage/v1/object/public/{$bucket}/";
            $bucketPrefix = "{$bucket}/";

            if (Str::startsWith($path, $publicPrefix)) {
                $path = Str::after($path, $publicPrefix);
            } elseif (Str::startsWith($path, $bucketPrefix)) {
                $path = Str::after($path, $bucketPrefix);
            }
        }

        return $path !== '' ? $path : null;
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN SECTION
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Destination::query();

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        $destinations = $query->latest()->paginate(10);
        return view('admin.destinations', compact('destinations'));
    }

    public function create()
    {
        return view('admin.destinations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'location'     => 'required|string|max:255',
            'description'  => 'required|string',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'facilities'   => 'nullable|array',
            'facilities.*' => 'nullable|string|max:255',
        ]);

        if (!empty($validated['facilities'])) {
            $validated['facilities'] = array_values(array_filter(array_map('trim', $validated['facilities'])));
        } else {
            $validated['facilities'] = [];
        }

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $filename = Str::slug($request->name) . '-' . time() . '.' . $request->image->extension();
            $path = $request->file('image')->storeAs('destinations', $filename, 's3');

            if (!is_string($path) || trim($path) === '') {
                return back()->withErrors(['image' => 'The image could not be uploaded.'])->withInput();
            }

            $validated['image'] = Storage::disk('s3')->url($path);
        } else {
            $validated['image'] = null;
        }

        $destination = Destination::create($validated);

        Activity::create([
            'user_id'     => auth()->id(),
            'action'      => 'create',
            'model'       => 'Destination',
            'model_id'    => $destination->id,
            'description' => "Created destination: {$destination->name}"
        ]);

        return redirect()->route('admin.destinations')->with('success', 'Destination created successfully!');
    }

    public function edit($id)
    {
        $destination = Destination::findOrFail($id);
        return view('admin.destinations.edit', compact('destination'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'location'     => 'required|string|max:255',
            'description'  => 'required|string',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'facilities'   => 'nullable|array',
            'facilities.*' => 'nullable|string|max:255',
        ]);

        $destination = Destination::findOrFail($id);

        if (!empty($validated['facilities'])) {
            $validated['facilities'] = array_values(array_filter(array_map('trim', $validated['facilities'])));
        } else {
            $validated['facilities'] = [];
        }

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $oldPath = $this->storageKey($destination->image);

            if ($oldPath !== null) {
                Storage::disk('s3')->delete($oldPath);
            }

            $filename = Str::slug($request->name) . '-' . time() . '.' . $request->image->extension();
            $path = $request->file('image')->storeAs('destinations', $filename, 's3');

            if (!is_string($path) || trim($path) === '') {
                return back()->withErrors(['image' => 'The image could not be uploaded.'])->withInput();
            }

            $validated['image'] = Storage::disk('s3')->url($path);
        }

        $destination->update($validated);

        Activity::create([
            'user_id'     => auth()->id(),
            'action'      => 'update',
            'model'       => 'Destination',
            'model_id'    => $destination->id,
            'description' => "Updated destination: {$destination->name}"
        ]);

        return redirect()->route('admin.destinations')->with('success', 'Destination updated successfully!');
    }

    public function destroy($id)
    {
        $destination = Destination::findOrFail($id);

        $oldPath = $this->storageKey($destination->image);

        if ($oldPath !== null) {
            Storage::disk('s3')->delete($oldPath);
        }

        $destination->delete();

        Activity::create([
            'user_id'     => auth()->id(),
            'action'      => 'delete',
            'model'       => 'Destination',
            'model_id'    => $destination->id,
            'description' => "Deleted destination: {$destination->name}"
        ]);

        return redirect()->route('admin.destinations')->with('success', 'Destination deleted successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | USER SECTION
    |--------------------------------------------------------------------------
    */
    public function list(Request $request)
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

    public function show($slug)
    {
        $destination = Destination::with(['reviews.user'])->where('slug', $slug)->firstOrFail();
        $destinations = Destination::all();
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