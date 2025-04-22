<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
        $product = Product::findOrFail($id);
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
        return $product->update($validated);
    }
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        return $product->delete();
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
            'brands' => $brands
        ]);
    }
}
