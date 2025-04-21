<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;


class CartController extends Controller
{
    public function addProduct(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        if (Auth::check()) {
            $cartItem = Cart::firstOrNew([
                'user_id' => Auth::id(),
                'product_id' => $productId
            ]);
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += 1;
            } else {
                $cart[$productId] = [
                    'product_id' => $productId,
                    'name' => $product->name,
                    'price' => $product->price,
                    'isSale' => $product->isSale,
                    'salePrice' => $product->salePrice,
                    'quantity' => 1,
                    'image' => $product->slug,
                ];
            }
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Produkt bol úspešne pridaný do košíka.');
    }
}
