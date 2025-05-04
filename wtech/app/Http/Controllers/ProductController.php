<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSizes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
  public function index()
  {
    return Product::paginate(12);
  }
  public function show($id)
  {
    return Product::findOrFail($id);
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'slug' => 'required|string|max:255',
      'description' => 'required|string',
      'manufacturer' => 'required|string|max:255',
      'gender' => 'required|in:Men,Women,Unisex',
      'color' => 'required|string|max:255',
      'type' => 'required|string|max:255',
      'price' => 'required|numeric|min:0',
      'isSale' => 'required|boolean',
      'salePrice' => 'required_if:isSale,true|numeric|min:0',
      'release_date' => 'required|date|before_or_equal:today'
    ]);
    return Product::create($validated);
  }

  public function update(Request $request, $id)
  {
    $validated = $request->validate([
      'product-name' => 'required|string',
      'product-description' => 'required|string',
      'product-price' => 'required|numeric',
      'product-sale-price' => 'nullable|numeric',
      'product-manufacturer' => 'required|string',
      'product-type' => 'required|string',
      'product-color' => 'required|string',
      'product-date' => 'required|integer',
      'product-gender' => 'required|string',
      'product-images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $product = Product::find($id);

    $newSlug = $product->slug;
    if ($product->name != $request->input('product-name')) {
      $oldPath = 'optimized_products/' . $newSlug;
      $newSlug = Str::slug($product->name);
      $newPath = 'optimized_products/' . $newSlug;

      if (Storage::disk('public')->exists($oldPath)) {
        Storage::disk('public')->move($oldPath, $newPath);
      }
    }

    $product->update([
      'slug' => $newSlug,
      'name' => $request->input('product-name'),
      'description' => $request->input('product-description'),
      'price' => $request->input('product-price'),
      'salePrice' => $request->input('product-sale-price'),
      'manufacturer' => $request->input('product-manufacturer'),
      'type' => $request->input('product-type'),
      'color' => $request->input('product-color'),
      'release_date' => $request->input('product-date') . '-01-01',
      'gender' => $request->input('product-gender'),
    ]);

    $sizes = [36, 38, 39, 40, 41, 42, 43, 44];
    $selectedSizes = $request->input('sizes', []);
    foreach ($sizes as $size) {
      $productSize = ProductSizes::where('product_id', $product->id)->where('size', $size)->first();
      if (in_array($size, $selectedSizes) && !isset($productSize)) {
        ProductSizes::create([
          'product_id' => $product->id,
          'size' => $size,
          'quantity' => 5
        ]);
      } else if (!in_array($size, $selectedSizes) && isset($productSize)) {
        $productSize->delete();
      }
    }


    $path = public_path('images/optimized_products/' . $newSlug);
    $count = 0;
    if (File::exists($path)) {
      $count = collect(File::files($path))
        ->filter(fn($file) => in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'gif']))
        ->count();
    }

    if ($request->hasFile('product-images')) {
      foreach ($request->file('product-images') as $image) {
        $img = $image->getRealPath();

        switch ($image->getClientOriginalExtension()) {
          case 'jpeg':
          case 'jpg':
            $sourceImage = imagecreatefromjpeg($img);
            break;
          case 'png':
            $sourceImage = imagecreatefrompng($img);
            break;
          default:
            continue 2;
        }

        $imageName = $count + 1 . '.jpg';
        $imagePath = public_path('images/optimized_products/' . $newSlug . '/');

        imagejpeg($sourceImage, $imagePath . $imageName, 90);
        imagedestroy($sourceImage);
        $count++;
      }
    }

    return redirect('/' . $product->slug);
  }
  public function delete($slug)
  {
    $product = Product::where('slug', $slug)->first();
    $product->delete();

    return redirect()->route('men');
  }

  public function filter(Request $request)
  {
    $query = Product::query();


    // prices
    if ($request->filled('price-from')) {
      $query->where('price', '>=', $request->input('price-from'));
    }
    if ($request->filled('price-to')) {
      $query->where('price', '<=', $request->input('price-to'));
    }

    // brands
    $brands = $request->input('brand', []);
    if (!empty($brands)) {
      $query->whereIn('manufacturer', $brands);
    }

    // color
    $colors = [];
    if ($request->has('color')) {
      $colorParam = $request->input('color');
      $colors = is_array($colorParam) ? $colorParam : explode(',', $colorParam);
      $query->whereIn('color', $colors);
    }

    // size
    $sizes = $request->input('size', []); // Default to an empty array if not provided

    // If the 'size' input is a string (comma-separated), convert it into an array
    if (is_string($sizes)) {
      $sizes = explode(',', $sizes);
    }

    // Ensure that the 'sizes' array is not empty
    if (!empty($sizes)) {
      // Update the query to filter based on multiple sizes
      $query->whereHas('sizes', function ($q) use ($sizes) {
        $q->whereIn('size', $sizes);  // Use whereIn to check for multiple sizes
      });
    }

    if ($request->filled('sort')) {
      switch ($request->input('sort')) {
        case 'price-asc':
          $query->orderBy('price', 'asc');
          break;
        case 'price-desc':
          $query->orderBy('price', 'desc');
          break;
        case 'alphabetical':
          $query->orderBy('name', 'asc');
          break;
        case 'newest':
          $query->orderBy('release_date', 'desc');
          break;
      }
    }

    $products = $query->paginate(12);
    return view('pages.store', [
      'title' => 'NaNohu - Filter',
      'category' => 'Filter',
      'products' => $products,
      'priceFrom' => $request->input('price-from'),
      'priceTo' => $request->input('price-to'),
      'colors' => $colors,
      'sizes' => $sizes,
      'colorString' => $request->input('color'),
      'sizeString' => $request->input('size'),
      'brands' => $brands,
      'sort' => $request->input('sort')
    ]);
  }
}
