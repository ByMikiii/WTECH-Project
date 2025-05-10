<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSizes;
use App\Models\Cart;


class CartController extends Controller
{
  public function addProduct(Request $request, $productId)
  {
    $request->validate([
      'size' => 'required|numeric',
      'quantity' => 'required|integer|min:1|max:5',
    ]);

    $product = Product::findOrFail($productId);
    $size = $request->input('size');
    $quantity = $request->input('quantity');

    if (Auth::check()) {
      $cartItem = Cart::firstOrNew([
        'user_id' => Auth::id(),
        'product_id' => $productId,
        'size' => $size
      ]);
      $cartItem->quantity += $quantity;
      $cartItem->save();
    } else {
      $cart = session()->get('cart', []);
      if (isset($cart[$productId][$size])) {
        $cart[$productId][$size]['quantity'] += $quantity;
      } else {
        $cart[$productId][$size] = [
          'product_id' => $productId,
          'name' => $product->name,
          'price' => $product->price,
          'isSale' => $product->isSale,
          'salePrice' => $product->salePrice,
          'quantity' => $quantity,
          'image' => $product->slug,
          'size' => $size
        ];
      }
      session()->put('cart', $cart);
    }
    return redirect()->back()->with('notification', 'Produkt bol úspešne pridaný do košíka.');
  }
  public function incrementItem($productId, $size)
  {
    if (Auth::check()) {
      $cartItem = Cart::where([
        'user_id' => Auth::id(),
        'product_id' => $productId,
        'size' => $size,
      ])->first();

      if ($cartItem && $cartItem->quantity < 5) {
        $cartItem->quantity++;
        $cartItem->save();
      }
    } else {
      $cart = session()->get('cart', []);
      if (isset($cart[$productId][$size]) && $cart[$productId][$size]['quantity'] < 5) {
        $cart[$productId][$size]['quantity']++;
        session()->put('cart', $cart);
      }
    }

    return redirect()->back();
  }

  public function decrementItem($productId, $size)
  {
    if (Auth::check()) {
      $cartItem = Cart::where([
        'user_id' => Auth::id(),
        'product_id' => $productId,
        'size' => $size,
      ])->first();

      if ($cartItem && $cartItem->quantity > 1) {
        $cartItem->quantity--;
        $cartItem->save();
      }
    } else {
      $cart = session()->get('cart', []);
      if (isset($cart[$productId][$size]) && $cart[$productId][$size]['quantity'] > 1) {
        $cart[$productId][$size]['quantity']--;
        session()->put('cart', $cart);
      }
    }

    return redirect()->back();
  }
  public function removeItem($productId, $size)
  {
    if (Auth::check()) {
      Cart::where([
        'user_id' => Auth::id(),
        'product_id' => $productId,
        'size' => $size,
      ])->delete();
    } else {
      $cart = session()->get('cart', []);
      if (isset($cart[$productId][$size])) {
        unset($cart[$productId][$size]);

        if (empty($cart[$productId])) {
          unset($cart[$productId]);
        }

        session()->put('cart', $cart);
      }
    }

    return redirect()->back()->with('notification', 'Produkt bol odstránený z košíka.');
  }

}
