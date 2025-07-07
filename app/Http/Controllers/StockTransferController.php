<?php

namespace App\Http\Controllers;

use App\Models\StockTransfer;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockTransferController extends Controller
{
    public function create()
    {
        $inventories = Inventory::with(['product', 'location'])->get();
        $locations = Location::all();
        return view('stock_transfers.create', compact('inventories', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'from_location_id' => 'required|exists:locations,id',
            'to_location_id' => 'required|exists:locations,id|different:from_location_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $inventory = Inventory::with(['product', 'location'])->findOrFail($request->inventory_id);
        if ($inventory->location_id != $request->from_location_id) {
            return redirect()->back()->with('error', 'Selected inventory does not match source location.');
        }
        if ($inventory->quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough stock at source location.');
        }

        $toInventory = Inventory::firstOrNew([
            'product_id' => $inventory->product_id,
            'location_id' => $request->to_location_id,
        ]);

        $inventory->quantity -= $request->quantity;
        $inventory->save();

        $toInventory->quantity += $request->quantity;
        $toInventory->save();

        StockTransfer::create([
            'product_id' => $inventory->product_id,
            'from_location_id' => $request->from_location_id,
            'to_location_id' => $request->to_location_id,
            'quantity' => $request->quantity,
            'user_id' => Auth::id(),
            'note' => $request->note,
        ]);

        return redirect()->route('inventory.index')->with('success', 'Stock transferred successfully.');
    }
}
