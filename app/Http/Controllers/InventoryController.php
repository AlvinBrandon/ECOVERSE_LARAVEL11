<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;

class InventoryController extends Controller
{
    public function index()
    {
        $inventory = Inventory::with('product')->get();
        return view('inventory.index', compact('inventory'));
    }

    public function create()
    {
        $products = Product::all();
        return view('inventory.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'batch_id' => 'nullable|string|max:255',
        ]);

        $inventory = Inventory::firstOrNew([
            'product_id' => $request->product_id,
            'batch_id' => $request->batch_id,
        ]);

        $inventory->quantity += $request->quantity;
        $inventory->save();

        return redirect()->route('inventory.index')->with('success', 'Inventory updated successfully.');
    }
}
