<?php

namespace App\Http\Controllers;

use App\Models\StockTransfer;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\InventoryUpdated;

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
        // StockHistory for source (deduct)
        \App\Models\StockHistory::create([
            'inventory_id' => $inventory->id,
            'user_id' => Auth::id(),
            'action' => 'deduct',
            'quantity_before' => $inventory->quantity + $request->quantity,
            'quantity_after' => $inventory->quantity,
            'note' => 'Stock transferred out',
        ]);
        // Broadcast inventory update event for source
        event(new InventoryUpdated('deduct', $inventory->product_id, $inventory->batch_id ?? null, $request->quantity, Auth::id()));

        $toInventory->quantity += $request->quantity;
        $toInventory->save();
        // StockHistory for destination (add)
        \App\Models\StockHistory::create([
            'inventory_id' => $toInventory->id,
            'user_id' => Auth::id(),
            'action' => 'add',
            'quantity_before' => $toInventory->quantity - $request->quantity,
            'quantity_after' => $toInventory->quantity,
            'note' => 'Stock transferred in',
        ]);
        // Broadcast inventory update event for destination
        event(new InventoryUpdated('add', $toInventory->product_id, $toInventory->batch_id ?? null, $request->quantity, Auth::id()));

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
