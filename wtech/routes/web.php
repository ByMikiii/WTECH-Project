<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use Illuminate\Support\Facades\File;

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
        'title' => 'NaNohu - Novinky',
        'category' => 'Novinky',
        'products' => $products
    ]);
});

Route::get('/men', function () {
    $products = Product::where('gender', 'Men')->orWhere('gender', 'Unisex')->paginate(12);
    return view('pages.store', [
        'title' => 'NaNohu - Muži',
        'category' => 'Muži',
        'products' => $products
    ]);
});

Route::get('/women', function () {
    $products = Product::where('gender', 'Women')->orWhere('gender', 'Unisex')->paginate(12);
    return view('pages.store', [
        'title' => 'NaNohu - Ženy',
        'category' => 'Ženy',
        'products' => $products
    ]);
});

Route::get('/search', function (\Illuminate\Http\Request $request) {
    $query = strtolower($request->input('search'));
    $products = Product::whereRaw('LOWER(name) LIKE ?', ['%' . $query . '%'])
        ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $query . '%'])
        ->paginate(12);
    return view('pages.store', [
        'title' => 'NaNohu - ' . $query,
        'category' => 'Vyhladávanie',
        'search' => $query,
        'products' => $products
    ]);
})->name('search');

Route::get('/sale', function () {
    $products = Product::where('isSale', true)->paginate(12);
    return view('pages.store', [
        'title' => 'NaNohu - Domov',
        'category' => 'Výpredaj',
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

    $path = public_path('images/optimized_products/' . $slug);

    $count = 0;
    if (File::exists($path)) {
        $count = collect(File::files($path))
            ->filter(fn($file) => in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'gif']))
            ->count();
    }
    return view('pages.product', [
        'title' => $product->name . ' - NaNohu',
        'product' => $product,
        'imagesCount' => $count
    ]);
});


#Products REST
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::post('products', [ProductController::class, 'store']);
Route::put('products/{id}', [ProductController::class, 'update']);
Route::delete('products/{id}', [ProductController::class, 'delete']);
