<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;

class OrderController extends Controller
{
  public function control_card_data(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'card_number' => ['required', 'digits:16'],
      'duration' => ['required', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
      'cvv' => ['required', 'digits:3'],
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput()
        ->with('notification', 'Zadané údaje sú nesprávne.');
    }

    return redirect('/create_order');
  }

  public function create_order(Request $request)
  {
    $orderData = session('order_data');
    $total_price = session('total');

    $order = Order::create([
      'email' => $orderData['email'],
      'first_name' => $orderData['first_name'],
      'last_name' => $orderData['last_name'],
      'phone' => $orderData['phone'],
      'street' => $orderData['street'],
      'city' => $orderData['city'],
      'postal_code' => $orderData['postal_code'],
      'pay' => $orderData['pay'],
      'delivery' => $orderData['delivery'],
      'total_price' => $total_price,
    ]);

    if (Auth::check()) {
      $userId = Auth::id();
      $cartItems = Cart::where('user_id', $userId)->get();

      foreach ($cartItems as $item) {
        $order->items()->create([
          'product_id' => $item->product_id,
          'order_id' => $order->id,
          'quantity' => $item->quantity,
          'size' => $item->size,
        ]);
      }

      Cart::where('user_id', $userId)->delete();
      session()->forget('orderData');
      return redirect('/');
    } else {
      $cart = session('cart');

      foreach ($cart as $productId => $sizes) {
        foreach ($sizes as $size => $item) {
          $order->items()->create([
            'product_id' => $item['product_id'],
            'order_id' => $order->id,
            'quantity' => $item['quantity'],
            'size' => $item['size'],
          ]);
        }
      }

      session()->forget('cart');

      session()->forget('orderData');

      return redirect('/')->with('notification', 'Objednávka prebehla úspešne!');
    }
  }
}
