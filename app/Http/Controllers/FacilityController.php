<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Destination;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::with('destination')->latest()->get();
        $destinations = Destination::all();
        return view('admin.facilities', compact('facilities', 'destinations'));
    }

    public function create()
    {
        $destinations = Destination::all();
        return view('admin.facilities.create', compact('destinations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'facility'       => 'required|string|max:255',
        ]);

        Facility::create($validated);

        return redirect('/admin/facilities')->with('success', 'Facility created successfully!');
    }

    public function edit($id)
    {
        $facility = Facility::findOrFail($id);
        $destinations = Destination::all();
        return view('admin.facilities.edit', compact('facility', 'destinations'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'facility'       => 'required|string|max:255',
        ]);

        $facility = Facility::findOrFail($id);
        $facility->update($validated);

        return redirect('/admin/facilities')->with('success', 'Facility updated successfully!');
    }

    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        $facility->delete();

        return redirect('/admin/facilities')->with('success', 'Facility deleted successfully!');
    }
}
