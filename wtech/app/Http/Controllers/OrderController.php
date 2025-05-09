<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller{
    public function create_order(Request $request){
        $orderData = session('order_data');

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
        ]);

        return redirect('/');
    }
}