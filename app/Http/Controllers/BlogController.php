<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Blog;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    // Admin
    public function index() {
        $blogs = Blog::latest()->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create() {
        $destinations = Destination::latest()->get();
        return view('admin.blogs.create', compact('destinations'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'destinations' => 'nullable|array|max:3',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog = Blog::create($validated);

        // Simpan relasi destinasi (pivot)
        if ($request->has('destinations')) {
            $blog->destinations()->sync($request->destinations);
        }

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'model' => 'Blog',
            'model_id' => $blog->id,
            'description' => "Created blog: {$blog->title}"
        ]);

        return redirect('/admin/blogs')->with('success','Blog created successfully!');
    }

    public function edit(Blog $blog) {
        $destinations = Destination::latest()->get();
        $selectedDestinations = $blog->destinations->pluck('id')->toArray();
        return view('admin.blogs.edit', compact('blog','destinations','selectedDestinations'));
    }

    public function update(Request $request, Blog $blog) {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'destinations' => 'nullable|array|max:3',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($validated);

        // Update relasi destinasi
        if ($request->has('destinations')) {
            $blog->destinations()->sync($request->destinations);
        } else {
            $blog->destinations()->detach();
        }

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model' => 'Blog',
            'model_id' => $blog->id,
            'description' => "Updated blog: {$blog->title}"
        ]);

        return redirect('/admin/blogs')->with('success','Blog updated successfully!');
    }

    public function destroy(Blog $blog) {
        $blog->delete();

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'model' => 'Blog',
            'model_id' => $blog->id,
            'description' => "Deleted blog: {$blog->title}"
        ]);

        return redirect('/admin/blogs')->with('success','Blog deleted successfully!');
    }

    // User
    public function list() {
        $blogs = Blog::latest()->get();
        return view('blogs.index', compact('blogs'));
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        $recentBlogs = Blog::where('id', '!=', $id)
                        ->latest()
                        ->take(3)
                        ->get();

        // Suggested destinations (ambil relasi blog)
        $suggestedDestinations = $blog->destinations()->take(3)->get();

        return view('blogs.show', compact('blog','recentBlogs','suggestedDestinations'));
    }
}
