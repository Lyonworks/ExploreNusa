<?php

namespace App\Http\Controllers;
use App\Models\TopDestination;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TopDestinationController extends Controller {
    public function index() {
        $tops = TopDestination::with('destination')->get();
        return view('admin.top.index', compact('tops'));
    }
    public function create() {
        $destinations = Destination::all();
        return view('admin.top.create', compact('destinations'));
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'title'=>'required',
            'destination_id'=>'nullable|exists:destinations,id',
            'image'=>'nullable|image|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $filename = Str::slug($request->title).'.'.$request->image->extension();
            $request->image->storeAs('public/top', $filename);
            $validated['image'] = 'top/'.$filename;
        }
        TopDestination::create($validated);
        return redirect()->route('top.index')->with('success','Top Tour created!');
    }
    public function edit($id) {
        $top = TopDestination::findOrFail($id);
        $destinations = Destination::all();
        return view('admin.top.edit', compact('top','destinations'));
    }
    public function update(Request $request,$id) {
        $top = TopDestination::findOrFail($id);
        $validated = $request->validate([
            'title'=>'required',
            'destination_id'=>'nullable|exists:destinations,id',
            'image'=>'nullable|image|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $filename = Str::slug($request->title).'.'.$request->image->extension();
            $request->image->storeAs('public/top', $filename);
            $validated['image'] = 'top/'.$filename;
        }
        $top->update($validated);
        return redirect()->route('top.index')->with('success','Top Tour updated!');
    }
    public function destroy($id) {
        TopDestination::destroy($id);
        return back()->with('success','Top Tour deleted!');
    }
}
