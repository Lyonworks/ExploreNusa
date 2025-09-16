<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Destination;
use App\Models\TopDestination;
use Illuminate\Http\Request;

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
            'destination_id'=>'nullable|exists:destinations,id'
        ]);

        $top = TopDestination::create($validated);

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'model' => 'TopDestination',
            'model_id' => $top->id,
            'description' => "Created Top Destination: {$top->id}"
        ]);

        return redirect('/admin/top')->with('success','Top Tour created!');
    }

    public function edit($id) {
        $top = TopDestination::findOrFail($id);
        $destinations = Destination::all();
        return view('admin.top.edit', compact('top','destinations'));
    }

    public function update(Request $request,$id) {
        $top = TopDestination::findOrFail($id);
        $validated = $request->validate([
            'destination_id'=>'nullable|exists:destinations,id'
        ]);

        $top->update($validated);

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model' => 'TopDestination',
            'model_id' => $top->id,
            'description' => "Updated Top Destination: {$top->id}"
        ]);

        return redirect('/admin/top')->with('success','Top Tour updated!');
    }

    public function destroy($id) {
        $top = TopDestination::findOrFail($id);

        $top->delete();

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'model' => 'TopDestination',
            'model_id' => $top->id,
            'description' => "Deleted Top Destination: {$top->id}"
        ]);

        return redirect('/admin/top')->with('success','Top Tour deleted!');
    }
}
