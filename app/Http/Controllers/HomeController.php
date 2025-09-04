<?php
namespace App\Http\Controllers;
use App\Models\Destination;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller {
    public function index() {
        $destinations = Destination::latest()->take(6)->get();
        $reviews = Review::latest()->take(3)->get();
        return view('home', compact('destinations','reviews'));
    }

    public function search(Request $request) {
        $keyword = $request->keyword;
        $destinations = Destination::where('name','like',"%$keyword%")->get();
        return view('search', compact('destinations','keyword'));
    }
}
