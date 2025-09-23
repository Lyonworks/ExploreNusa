<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Review;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $destinations = Destination::all();

        $reviews = Review::with(['user','destination'])
            ->when($request->destination_id, fn($q) => $q->where('destination_id', $request->destination_id))
            ->when($request->rating, fn($q) => $q->where('rating', $request->rating))
            ->latest()
            ->get();

        return view('admin.reviews', compact('reviews', 'destinations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|string|max:500',
        ]);

        $review = Review::create([
            'destination_id' => $request->destination_id,
            'user_id' => Auth::id(),
            'guest_name' => $request->guest_name,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'model' => 'Review',
            'model_id' => $review->id,
            'description' => "Created review by: " . ($review->user->name ?? $review->guest_name ?? 'Guest')
        ]);

        return back()->with('success', 'Thank you for your review!');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'model' => 'Review',
            'model_id' => $review->id,
            'description' => "Deleted review by: " . ($review->user->name ?? $review->guest_name ?? 'Guest')
        ]);

        return redirect()->route('reviews.index')->with('success', 'Review deleted successfully.');
    }
}
