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
      return redirect()->back()->with('notification', 'Recenzia bola úspešne vytvorená!');
    }
    return redirect()->back()->with('notification', 'Na vytvorenie recenzie musíte byť prihlásený!');
  }
  public function deleteReview($productId)
  {
    if (Auth::check()) {
      Review::where('user_id', Auth::id())
        ->where('product_id', $productId)
        ->delete();
      return redirect()->back()->with('notification', 'Recenzia bola úspešne odstránená!');
    }
    return redirect()->back()->with('notification', 'Na odstránenie recenzie musíte byť prihlásený!');
  }
}
