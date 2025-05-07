<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller{
    public function create_order(Request $request){
        
        return redirect('/summary');
    }
}