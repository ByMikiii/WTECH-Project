<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class ReviewController extends Controller
{
    public function createReview(Request $request, $productId)
    {
        $rating = $request->input('rating');
        $text = $request->input('text');
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'text' => 'nullable|string|max:1000'
        ]);
        if (Auth::check()) {
            Review::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'rating' => $rating,
                'text' => $text,
                'created_at' => now()
            ]);
            return redirect()->back()->with('success');
        }
        return redirect()->back()->withErrors(['You must be logged in to leave a review.']);
    }
}
