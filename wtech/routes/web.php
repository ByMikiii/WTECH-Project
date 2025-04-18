<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

Route::get('/', function () {
    $saleProducts = Product::where('isSale', true)->take(4)->get();
    $newProducts = Product::latest()->take(4)->get();
    $hotProduct = Product::orderByDesc('price')->first();
    return view('pages.home', [
        'title' => 'NaNohu - Domov',
        'saleProducts' => $saleProducts,
        'newProducts' => $newProducts,
        'hotProduct' => $hotProduct
    ]);
});

#Products REST
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::post('products', [ProductController::class, 'store']);
Route::put('products/{id}', [ProductController::class, 'update']);
Route::delete('products/{id}', [ProductController::class, 'delete']);
