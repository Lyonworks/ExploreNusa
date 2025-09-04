<?php
namespace App\Http\Controllers;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller {
    public function index() {
        $facilities = Facility::all();
        return view('admin.facilities', compact('facilities'));
    }

    public function store(Request $request) {
        Facility::create($request->all());
        return back();
    }

    public function update(Request $request, $id) {
        $facility = Facility::findOrFail($id);
        $facility->update($request->all());
        return back();
    }

    public function destroy($id) {
        Facility::destroy($id);
        return back();
    }
}
