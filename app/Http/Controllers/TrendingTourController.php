<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Destination;
use App\Models\TrendingTour;
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
            'destination_id'=>'nullable|exists:destinations,id'
        ]);

        $tour = TrendingTour::create($validated);

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model' => 'TrendingTour',
            'model_id' => $tour->id,
            'description' => "Updated Trending Tour: {$tour->id}"
        ]);

        return redirect('/admin/trending')->with('success','Trending Tour created!');
    }

    public function edit($id) {
        $tour = TrendingTour::findOrFail($id);
        $destinations = Destination::all();
        return view('admin.trending.edit', compact('tour','destinations'));
    }

    public function update(Request $request,$id) {
        $tour = TrendingTour::findOrFail($id);
        $validated = $request->validate([
            'destination_id'=>'nullable|exists:destinations,id'
        ]);

        $tour->update($validated);

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model' => 'TrendingTour',
            'model_id' => $tour->id,
            'description' => "Updated Trending Tour: {$tour->id}"
        ]);

        return redirect('/admin/trending')->with('success','Trending Tour updated!');
    }

    public function destroy($id) {
        $tour = TrendingTour::findOrFail($id);

        $tour->delete();

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'model' => 'TrendingTour',
            'model_id' => $tour->id,
            'description' => "Deleted Trending Tour: {$tour->id}"
        ]);

        // gunakan redirect yang benar
        return redirect('/admin/trending')->with('success','Trending Tour deleted!');
    }
}
