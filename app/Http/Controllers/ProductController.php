<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display a listing of the products
    public function index()
    {
        $products = Product::all();
        return view('pages.products', compact('products'));
    }

    // Display the specified product
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.product-details', compact('product'));
    }

    // Store a newly created product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|string',
        ]);
        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    // Update the specified product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
            'image' => 'nullable|string',
        ]);
        $product->update($validated);
        return response()->json($product);
    }

    // Remove the specified product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }
} 