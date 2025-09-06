<?php

namespace App\Http\Controllers;
use App\Models\TrendingTour;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrendingTourController extends Controller {
    public function index() {
        $tours = TrendingTour::with('destination')->get();
        return view('admin.trending.index', compact('tours'));
    }
    public function create() {
        $destinations = Destination::all();
        return view('admin.trending.create', compact('destinations'));
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'title'=>'required',
            'destination_id'=>'nullable|exists:destinations,id',
            'image'=>'nullable|image|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $filename = Str::slug($request->title).'.'.$request->image->extension();
            $request->image->storeAs('public/trending', $filename);
            $validated['image'] = 'trending/'.$filename;
        }
        TrendingTour::create($validated);
        return redirect()->route('trending.index')->with('success','Trending Tour created!');
    }
    public function edit($id) {
        $tour = TrendingTour::findOrFail($id);
        $destinations = Destination::all();
        return view('admin.trending.edit', compact('tour','destinations'));
    }
    public function update(Request $request,$id) {
        $tour = TrendingTour::findOrFail($id);
        $validated = $request->validate([
            'title'=>'required',
            'destination_id'=>'nullable|exists:destinations,id',
            'image'=>'nullable|image|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $filename = Str::slug($request->title).'.'.$request->image->extension();
            $request->image->storeAs('public/trending', $filename);
            $validated['image'] = 'trending/'.$filename;
        }
        $tour->update($validated);
        return redirect()->route('trending.index')->with('success','Trending Tour updated!');
    }
    public function destroy($id) {
        TrendingTour::destroy($id);
        return back()->with('success','Trending Tour deleted!');
    }
}
