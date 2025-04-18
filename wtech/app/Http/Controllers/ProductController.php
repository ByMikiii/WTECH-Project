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
}
