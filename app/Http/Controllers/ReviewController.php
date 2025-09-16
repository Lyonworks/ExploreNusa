<?php
namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller {
    public function index()
    {
        $reviews = Review::with(['user','destination'])->latest()->get();
        return view('admin.reviews', compact('reviews'));
    }

    public function store(Request $request) {
        $request->validate([
            'destination_id'=>'required',
            'rating'=>'required|numeric|min:1|max:5',
            'review'=>'required'
        ]);

        $review = Review::create([
            'destination_id' => $request->destination_id,
            'user_id' => Auth::id(),
            'guest_name' => $request->guest_name,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'model' => 'Review',
            'model_id' => $review->id,
            'description' => "Created review by: {$review->user->name}"
        ]);

        return back()->with('success', 'Thank you for your review!');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'model' => 'Review',
            'model_id' => $review->id,
            'description' => "Deleted review by: {$review->user->name}"
        ]);

        return redirect('/admin/reviews')->with('success', 'Review deleted successfully.');
    }
}
