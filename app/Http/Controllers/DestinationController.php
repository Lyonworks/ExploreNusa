<?php
namespace App\Http\Controllers;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller {
    // ADMIN
    public function index() {
        $destinations = Destination::all();
        return view('admin.destinations', compact('destinations'));
    }

    public function create() {
        return view('admin.form', ['destination'=>new Destination()]);
    }

    public function store(Request $request) {
        $request->validate(['name'=>'required','location'=>'required','description'=>'required']);
        Destination::create($request->all());
        return redirect('/admin/destinations');
    }

    public function edit($id) {
        $destination = Destination::findOrFail($id);
        return view('admin.form', compact('destination'));
    }

    public function update(Request $request, $id) {
        $destination = Destination::findOrFail($id);
        $destination->update($request->all());
        return redirect('/admin/destinations');
    }

    public function destroy($id) {
        Destination::destroy($id);
        return back();
    }

    // USER DETAIL
    public function show($id) {
        $destination = Destination::with(['facilities','reviews'])->findOrFail($id);
        return view('destination-detail', compact('destination'));
    }
}
