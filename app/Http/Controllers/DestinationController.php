<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN SECTION (CRUD)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $destinations = Destination::all();
        return view('admin.destinations', compact('destinations'));
    }

    public function create()
    {
        return view('admin.form', ['destination' => new Destination()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'location'    => 'required',
            'description' => 'required'
        ]);

        Destination::create($request->all());
        return redirect('/admin/destinations')->with('success', 'Destination created successfully!');
    }

    public function edit($id)
    {
        $destination = Destination::findOrFail($id);
        return view('admin.form', compact('destination'));
    }

    public function update(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);
        $destination->update($request->all());
        return redirect('/admin/destinations')->with('success', 'Destination updated successfully!');
    }

    public function destroy($id)
    {
        Destination::destroy($id);
        return back()->with('success', 'Destination deleted successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | USER SECTION (LIST & DETAIL)
    |--------------------------------------------------------------------------
    */

    // list destinasi
    public function list()
    {
        $destinations = Destination::all();
        return view('destinations.index', compact('destinations'));
    }

    // detail destinasi
    public function show($id)
    {
        $destination = Destination::with(['facilities', 'reviews'])->findOrFail($id);
        return view('destinations.show', compact('destination'));
    }
}
