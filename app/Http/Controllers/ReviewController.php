<?php
namespace App\Http\Controllers;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller {
    public function store(Request $request) {
        $request->validate([
            'destination_id'=>'required',
            'rating'=>'required|numeric|min:1|max:5',
            'review'=>'required'
        ]);
        Review::create($request->all());
        return back();
    }
}
