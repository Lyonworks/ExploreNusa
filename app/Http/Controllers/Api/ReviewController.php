<?php
namespace App\Http\Controllers\Api;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // POST /api/reviews
    public function store(Request $request)
    {
        $data = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
            'guest_name' => 'nullable|string|max:100',
            'guest_email' => 'nullable|email|max:150',
        ]);

        $user = $request->user(); // may be null (guest)
        if (!$user) {
            // For guests, require at least guest_name or guest_email
            if (empty($data['guest_name']) && empty($data['guest_email'])) {
                return response()->json(['message' => 'guest_name atau guest_email diperlukan untuk review tamu'], 422);
            }
        }

        $data['user_id'] = $user?->id;
        $data['ip_address'] = $request->ip();

        $review = Review::create($data);
        return response()->json(['message' => 'Review berhasil ditambahkan','data' => $review], 201);
    }
}