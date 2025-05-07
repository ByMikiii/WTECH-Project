<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Models\Product;
use App\Models\Cart;
use App\Models\ProductSizes;
use App\Models\Review;
use Database\Seeders\ProductSizesTableSeeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
})->name('men');

Route::get('/women', function () {
  $products = Product::where('gender', 'Women')->orWhere('gender', 'Unisex')->paginate(12);
  return view('pages.store', [
    'title' => 'NaNohu - Ženy',
    'category' => 'Ženy',
    'products' => $products
  ]);
})->name('men');

Route::get('/filter', [ProductController::class, 'filter'])->name('store.filter');

Route::get('/sale', function () {
  $products = Product::where('isSale', true)->paginate(12);
  return view('pages.store', [
    'title' => 'NaNohu - Domov',
    'category' => 'Výpredaj',
    'products' => $products
  ]);
});

Route::get('/cart', function () {
  $cartItems = collect();
  if (Auth::check()) {
    $items = Cart::where('user_id', Auth::id())->with('product')->get();

    // map to session format
    $cartItems = $items->mapWithKeys(function ($item) {
      $productId = $item->product->id;
      $size = $item->size;
      return [
        (string) $productId => [
          (string) $size => [
            'product_id' => (string) $productId,
            'name' => $item->product->name,
            'price' => $item->product->price,
            'isSale' => $item->product->isSale,
            'salePrice' => $item->product->salePrice,
            'quantity' => $item->quantity,
            'image' => $item->product->slug,
            'size' => (string) $size
          ]
        ]
      ];
    });
  } else {
    $sessionCart = session()->get('cart', []);
    $cartItems = collect($sessionCart)->map(function ($item) {
      return (object) $item;
    });
  }

  return view('pages.cart', [
    'title' => 'NaNohu - Košík',
    'cartItems' => $cartItems
  ]);
});

Route::get('/order', function () {
  $user = Auth::user();

  return view('pages.order', [
    'title' => 'NaNohu - Dodacie údaje',
    'email' => $user?->email ?? null,
    'name' => $user ? $user->first_name . ' ' . $user->last_name : null,
    'phone' => $user?->phone ?? null,
    'address' => $user?->postal_code ?? null
  ]);
});


Route::get('/summary', function () {
  $cartItems = collect();
  if (Auth::check()) {
    $items = Cart::where('user_id', Auth::id())->with('product')->get();

    // map to session format
    $cartItems = $items->mapWithKeys(function ($item) {
      $productId = $item->product->id;
      $size = $item->size;
      return [
        (string) $productId => [
          (string) $size => [
            'product_id' => (string) $productId,
            'name' => $item->product->name,
            'price' => $item->product->price,
            'isSale' => $item->product->isSale,
            'salePrice' => $item->product->salePrice,
            'quantity' => $item->quantity,
            'image' => $item->product->slug,
            'size' => (string) $size
          ]
        ]
      ];
    });
  } else {
    $sessionCart = session()->get('cart', []);
    $cartItems = collect($sessionCart)->map(function ($item) {
      return (object) $item;
    });
  }

  $total = 0;

  foreach ($cartItems as $product) {
    foreach ($product as $item) {
      $price = $item['isSale'] ? $item['salePrice'] : $item['price'];
      $total += $price * $item['quantity'];
    }
  }

  return view('pages.summary', [
    'title' => 'NaNohu - Košík',
    'cartItems' => $cartItems,
    'total' => $total
  ]);
});
Route::post('/cart/add/{productId}', [CartController::class, 'addProduct'])->name('cart.add');
Route::get('/cart/increment/{productId}/{size}', [CartController::class, 'incrementItem'])->name('cart.increment');
Route::get('/cart/decrement/{productId}/{size}', [CartController::class, 'decrementItem'])->name('cart.decrement');
Route::get('/cart/remove/{productId}/{size}', [CartController::class, 'removeItem'])->name('cart.remove');



Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', function () {
  return view('pages.register', ['title' => 'NaNohu - Registrácia']);
});

Route::get('/renew_password', function () {
  return view('pages.renew_password', ['title' => 'NaNohu - Obnova hesla']);
});

Route::get('/profile', function () {
  $user = Auth::user();

  return view('pages.profile', [
    'title' => 'NaNohu - Profil',
    'email' => $user->email,
    'name' => $user->first_name . ' ' . $user->last_name,
    'phone' => $user->phone,
    'address' => $user->street . ' ' . $user->city . ' ' . $user->postal_code ,
    'username' => $user->username,
  ]);
})->middleware('auth');

Route::get('/change_password', function () {
  return view('pages.change_password', ['title' => 'NaNohu - Zmena hesla']);
});

Route::post('/register', [RegisterController::class, 'register']);

Route::get('/edit_profile', function () {
  $user = Auth::user();
  return view('pages.edit_profile', [
    'title' => 'NaNohu - Úprava profilu',
    'email' => $user->email,
    'first_name' => $user->first_name,
    'last_name' => $user->last_name,
    'username' => $user->username,
    'phone' => $user->phone,
    'postal_code' => $user->postal_code,
    'city' => $user->city,
    'street' => $user->street,
  ]);
})->middleware('auth');

Route::post('/edit_profile', [ProfileController::class, 'edit_profile'])->middleware('auth');

Route::post('review/create/{productId}', [ReviewController::class, 'createReview']);
Route::post('review/delete/{productId}', [ReviewController::class, 'deleteReview']);

Route::get('/add_product', function () {
  return view('pages.add_product', [
    'title' => 'Nový produkt - NaNohu',
  ]);
});

Route::get('/{slug}/edit', function ($slug) {
  $product = Product::where('slug', $slug)->firstOrFail();
  $sizesArray = ProductSizes::where('product_id', $product->id)->get();
  $sizes = collect($sizesArray)->pluck('size')->all();
  $path = public_path('images/optimized_products/' . $slug);
  $count = 0;
  if (File::exists($path)) {
    $count = collect(File::files($path))
      ->filter(fn($file) => in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'gif']))
      ->count();
  }
  return view('pages.edit_product', [
    'title' => $product->name . ' - NaNohu',
    'product' => $product,
    'sizes' => $sizes,
    'imagesCount' => $count
  ]);
});

Route::post('products/{id}/remove', [ProductController::class, 'delete']);
Route::post('products/{id}/edit', [ProductController::class, 'update']);
Route::post('products/create', [ProductController::class, 'store']);


Route::get('/{slug}', function ($slug) {
  $product = Product::where('slug', $slug)->firstOrFail();
  $sizes = ProductSizes::where('product_id', $product->id)->get();
  $ownReview = Review::where('user_id', Auth::id())
    ->where('product_id', $product->id)
    ->first();
  $otherReviews = Review::where('user_id', '!=', Auth::id())
    ->where('product_id', $product->id)
    ->with('user')
    ->orderByDesc('created_at')
    ->get();

  $ratings = $otherReviews->pluck('rating')->toArray();
  if ($ownReview) {
    $ratings[] = $ownReview->rating;
  }
  $averageRating = !empty($ratings) ? round(array_sum($ratings) / count($ratings), 1) : 0;

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
    'imagesCount' => $count,
    'sizes' => $sizes,
    'ownReview' => $ownReview,
    'otherReviews' => $otherReviews,
    'averageRating' => $averageRating
  ]);
});
