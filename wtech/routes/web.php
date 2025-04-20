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

Route::get('/new', function () {
    $products = Product::latest()->paginate(12);
    return view('pages.store', [
        'title' => 'NaNohu - Domov',
        'products' => $products
    ]);
});



Route::get('/login', function () {
    return view('pages.login', ['title' => 'NaNohu - Prihlásenie']);
});

Route::get('/register', function () {
    return view('pages.register', ['title' => 'NaNohu - Registrácia']);
});

Route::get('/renew_password', function () {
    return view('pages.renew_password', ['title' => 'NaNohu - Obnova hesla']);
});

Route::get('/profile', function () {
    return view('pages.profile', ['title' => 'NaNohu - Profil']);
});

Route::get('/change_password', function () {
    return view('pages.change_password', ['title' => 'NaNohu - Zmena hesla']);
});





Route::get('/{slug}', function ($slug) {
    $product = Product::where('slug', $slug)->firstOrFail();

    return view('pages.product', [
        'title' => 'NaNohu - ' . $product->name,
        'product' => $product
    ]);
});


#Products REST
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::post('products', [ProductController::class, 'store']);
Route::put('products/{id}', [ProductController::class, 'update']);
Route::delete('products/{id}', [ProductController::class, 'delete']);
