<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Blog;
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
        return view('admin.blogs.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        Blog::create($validated);

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
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog) {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($validated);

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
        $blog = Blog::findOrFail($id);
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
        return view('blog', compact('blogs'));
    }

}
