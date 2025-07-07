<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowStockAlert;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index()
    {
        $productInventory = Inventory::with(['product'])->whereNotNull('product_id')->get();
        $totalValue = $productInventory->reduce(function ($carry, $item) {
            return $carry + (($item->product->price ?? 0) * $item->quantity);
        }, 0);
        return view('inventory.index', compact('productInventory', 'totalValue'));
    }

    public function create()
    {
        $products = Product::all();
        return view('inventory.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'batch_id' => 'nullable|string|max:255',
        ]);

        $inventory = Inventory::firstOrNew([
            'product_id' => $request->product_id,
            'batch_id' => $request->batch_id,
        ]);
        $before = $inventory->exists ? $inventory->quantity : 0;
        $inventory->quantity += $request->quantity;
        $inventory->save();
        // Log stock history
        StockHistory::create([
            'inventory_id' => $inventory->id,
            'user_id' => Auth::id(),
            'action' => 'add',
            'quantity_before' => $before,
            'quantity_after' => $inventory->quantity,
            'note' => 'Stock added via create form',
        ]);

        return redirect()->route('inventory.index')->with('success', 'Inventory updated successfully.');
    }

    public function deductForm()
    {
        $products = Product::all();
        return view('inventory.deduct', compact('products'));
    }

    public function deduct(Request $request)
    {
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'batch_id' => 'nullable|string|max:255',
        ]);

        $inventory = Inventory::where('batch_id', $request->batch_id)
            ->when($request->product_id, function ($query) use ($request) {
                $query->where('product_id', $request->product_id);
            })
            ->first();

        if (!$inventory) {
            return redirect()->back()->with('error', 'Inventory record not found for this item and batch.');
        }
        if ($inventory->quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Cannot deduct more than available stock.');
        }
        $before = $inventory->quantity;
        $inventory->quantity -= $request->quantity;
        $inventory->save();
        // Log stock deduction
        StockHistory::create([
            'inventory_id' => $inventory->id,
            'user_id' => Auth::id(),
            'action' => 'deduct',
            'quantity_before' => $before,
            'quantity_after' => $inventory->quantity,
            'note' => 'Stock deducted via deduct form',
        ]);
        // Low stock alert threshold
        if ($inventory->quantity <= 10) {
            $itemName = $inventory->product->name ?? 'Unknown';
            Mail::to('admin@example.com')->send(new LowStockAlert(
                $itemName,
                $inventory->batch_id,
                $inventory->quantity
            ));
        }
        return redirect()->route('inventory.index')->with('success', 'Stock deducted successfully.');
    }

    public function history()
    {
        $histories = \App\Models\StockHistory::with(['inventory.product', 'user'])->latest()->get();
        return view('inventory.history', compact('histories'));
    }

    public function export()
    {
        $inventory = Inventory::with('product')->whereNotNull('batch_id')->get();
        $filename = 'inventory_export_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ];
        $callback = function() use ($inventory) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Product', 'Batch ID', 'Quantity', 'Last Updated']);
            foreach ($inventory as $item) {
                fputcsv($handle, [
                    $item->product->name,
                    $item->batch_id,
                    $item->quantity,
                    $item->updated_at,
                ]);
            }
            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function analytics()
    {
        $totalValue = \App\Models\Inventory::with('product')
            ->get()
            ->sum(function($item) {
                return $item->quantity * ($item->product->unit_price ?? 0);
            });
        $totalProducts = \App\Models\Product::count();
        $lowStockCount = \App\Models\Inventory::where('quantity', '<=', 10)->count();
        $products = \App\Models\Product::all();
        $productNames = $products->pluck('name');
        $productQuantities = $products->map(function($product) {
            return $product->inventories->sum('quantity');
        });
        $historyDates = collect(range(0,6))->map(function($i) {
            return now()->subDays(6-$i)->format('Y-m-d');
        });
        $stockAdded = $historyDates->map(function($date) {
            return \App\Models\StockHistory::whereDate('created_at', $date)
                ->where('action', 'add')
                ->get()
                ->sum(function($h) { return $h->quantity_after - $h->quantity_before; });
        });
        $stockDeducted = $historyDates->map(function($date) {
            return \App\Models\StockHistory::whereDate('created_at', $date)
                ->where('action', 'deduct')
                ->get()
                ->sum(function($h) { return $h->quantity_before - $h->quantity_after; });
        });
        return view('inventory.analytics', compact(
            'totalValue', 'totalProducts', 'lowStockCount',
            'productNames', 'productQuantities',
            'historyDates', 'stockAdded', 'stockDeducted'
        ));
    }
}
