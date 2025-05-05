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

    $slug = Str::slug($request->input('product-name'));

    $product = Product::where('slug', $slug)->first();
    if (
      isset($product) ||
      !$request->hasFile('product-images') ||
      count($request->file('product-images')) < 2
    ) {
      return redirect()->back()->withInput();
    }

    $product = Product::create([
      'slug' => $slug,
      'name' => $request->input('product-name'),
      'description' => $request->input('product-description'),
      'price' => $request->input('product-price'),
      'salePrice' => $request->input('product-sale-price'),
      'isSale' => $request->input('product-sale-price') > 0,
      'manufacturer' => $request->input('product-manufacturer'),
      'type' => $request->input('product-type'),
      'color' => $request->input('product-color'),
      'release_date' => $request->input('product-date') . '-01-01',
      'gender' => $request->input('product-gender'),
    ]);

    $count = 1;
    if ($request->hasFile('product-images')) {
      foreach ($request->file('product-images') as $image) {
        $img = $image->getRealPath();

        // convert to jpg
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

        $imageName = $count . '.jpg';
        $imagePath = public_path('images/optimized_products/' . $slug . '/');
        if (!File::exists($imagePath)) {
          File::makeDirectory($imagePath, 0755, true);
        }

        $imageName = $count . '.jpg';
        imagejpeg($sourceImage, $imagePath . $imageName, 90);
        imagedestroy($sourceImage);
        $count++;
      }
    }

    $selectedSizes = $request->input('sizes', []);
    foreach ($selectedSizes as $selectedSize) {
      ProductSizes::create([
        'product_id' => $product->id,
        'size' => $selectedSize,
        'stock' => 5
      ]);
    }

    return redirect('/' . $slug);
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

    // rename images if new name
    $newSlug = $product->slug;
    if ($product->name != $request->input('product-name')) {
      $oldPath = 'optimized_products/' . $newSlug;
      $newSlug = Str::slug($product->name);
      $newPath = 'optimized_products/' . $newSlug;

      if (Storage::disk('public')->exists($oldPath)) {
        Storage::disk('public')->move($oldPath, $newPath);
      }
    }

    // update product
    $product->update([
      'slug' => $newSlug,
      'name' => $request->input('product-name'),
      'description' => $request->input('product-description'),
      'price' => $request->input('product-price'),
      'salePrice' => $request->input('product-sale-price'),
      'isSale' => $request->input('product-sale-price') > 0,
      'manufacturer' => $request->input('product-manufacturer'),
      'type' => $request->input('product-type'),
      'color' => $request->input('product-color'),
      'release_date' => $request->input('product-date') . '-01-01',
      'gender' => $request->input('product-gender'),
    ]);

    // update sizes
    $sizes = [36, 38, 39, 40, 41, 42, 43, 44];
    $selectedSizes = $request->input('sizes', []);
    foreach ($sizes as $size) {
      $productSize = ProductSizes::where('product_id', $product->id)->where('size', $size)->first();
      if (in_array($size, $selectedSizes) && !isset($productSize)) {
        ProductSizes::create([
          'product_id' => $product->id,
          'size' => $size,
          'stock' => 5
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

    $deletedImages = $request->input('images-to-delete', []);

    if ($request->hasFile('product-images')) {
      $numNew = count($request->file('product-images'));
    } else {
      $numNew = 0;
    }
    $numDeleted = count($deletedImages);


    if (count($deletedImages) != $count && $count + $numNew - $numDeleted >= 2) {
      // delete images
      foreach ($deletedImages as $deletedImage) {
        File::delete(public_path('/images/optimized_products/' . $newSlug . '/' . $deletedImage . '.jpg'));
      }

      // reorder images
      $directory = public_path('/images/optimized_products/' . $newSlug);
      $files = File::files($directory);

      $jpgFiles = collect($files)
        ->filter(fn($file) => $file->getExtension() === 'jpg')
        ->sortBy(fn($file) => $file->getFilename());

      $index = 1;
      foreach ($jpgFiles as $file) {
        $newName = $index . '.jpg';
        $newPath = $directory . '/' . $newName;
        if ($file->getFilename() !== $newName) {
          File::move($file->getPathname(), $newPath);
        }
        $index++;
      }

      if ($request->hasFile('product-images')) {
        foreach ($request->file('product-images') as $image) {
          $img = $image->getRealPath();

          // convert to jpg
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
    }

    return redirect('/' . $product->slug);
  }
  public function delete($id)
  {
    $product = Product::where('id', $id)->first();
    $product->delete();
    // File::delete(public_path('/images/optimized_products/' . $product->slug));

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
    $sizes = $request->input('size', []);

    if (is_string($sizes)) {
      $sizes = explode(',', $sizes);
    }

    if (!empty($sizes)) {
      $query->whereHas('sizes', function ($q) use ($sizes) {
        $q->whereIn('size', $sizes);
      });
    }

    // sort
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
