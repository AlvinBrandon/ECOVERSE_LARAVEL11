<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\StockHistory;
use App\Models\RawMaterial;
use App\Models\Batch;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowStockAlert;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index()
    {
        // Group products and sum their batch quantities
        $products = Product::with('batches')->get();
        $productInventory = $products->map(function($product) {
            return [
                'product' => $product,
                'quantity' => $product->batches->sum('quantity'),
                'updated_at' => $product->batches->max('updated_at'),
                'product_id' => $product->id,
            ];
        });
        $rawMaterialInventory = Inventory::with(['rawMaterial'])->whereNotNull('raw_material_id')->get();
        $totalValue = $products->reduce(function ($carry, $product) {
            return $carry + (($product->price ?? 0) * $product->batches->sum('quantity'));
        }, 0);
        return view('inventory.index', compact('productInventory', 'rawMaterialInventory', 'totalValue'));
    }

    public function create()
    {
        $products = Product::all();
        $rawMaterials = RawMaterial::all();
        return view('inventory.create', compact('products', 'rawMaterials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'raw_material_id' => 'nullable|exists:raw_materials,id',
            'quantity' => 'required|integer|min:1',
            'batch_id' => [
                'required',
                'string',
                'max:255',
                // Ensure unique batch_id for each product/raw_material
                function($attribute, $value, $fail) use ($request) {
                    if ($request->product_id) {
                        $exists = Batch::where('batch_id', $value)
                            ->where('product_id', $request->product_id)
                            ->exists();
                        if ($exists) {
                            $fail('The batch ID must be unique for each restock of this product.');
                        }
                    } else if ($request->raw_material_id) {
                        $exists = Inventory::where('batch_id', $value)
                            ->where('raw_material_id', $request->raw_material_id)
                            ->exists();
                        if ($exists) {
                            $fail('The batch ID must be unique for each restock of this raw material.');
                        }
                    }
                }
            ],
            'expiry_date' => 'nullable|date',
        ]);

        if ($request->product_id) {
            $batch = Batch::create([
                'product_id' => $request->product_id,
                'batch_id' => $request->batch_id,
                'quantity' => $request->quantity,
                'expiry_date' => $request->expiry_date,
            ]);
            // Ensure Inventory record exists for this product and batch
            $inventory = Inventory::firstOrNew([
                'product_id' => $request->product_id,
                'batch_id' => $request->batch_id,
            ]);
            $before = $inventory->exists ? $inventory->quantity : 0;
            $inventory->quantity += $request->quantity;
            $inventory->save();
            // Create StockHistory record for product batch addition
            StockHistory::create([
                'inventory_id' => $inventory->id,
                'user_id' => Auth::id(),
                'action' => 'add',
                'quantity_before' => $before,
                'quantity_after' => $inventory->quantity,
                'note' => 'Stock added via create form (batch)',
            ]);
        } else if ($request->raw_material_id) {
            $inventory = Inventory::firstOrNew([
                'raw_material_id' => $request->raw_material_id,
                'batch_id' => $request->batch_id,
            ]);
            $before = $inventory->exists ? $inventory->quantity : 0;
            $inventory->quantity += $request->quantity;
            $inventory->save();
            StockHistory::create([
                'inventory_id' => $inventory->id,
                'user_id' => Auth::id(),
                'action' => 'add',
                'quantity_before' => $before,
                'quantity_after' => $inventory->quantity,
                'note' => 'Stock added via create form',
            ]);
        }
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

        StockHistory::create([
            'inventory_id' => $inventory->id,
            'user_id' => Auth::id(),
            'action' => 'deduct',
            'quantity_before' => $before,
            'quantity_after' => $inventory->quantity,
            'note' => 'Stock deducted via deduct form',
        ]);

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
        $histories = StockHistory::with(['inventory.product', 'user'])->latest()->get();
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
        $totalValue = Inventory::with('product')->get()
            ->sum(function($item) {
                return $item->quantity * ($item->product->unit_price ?? 0);
            });

        $totalProducts = Product::count();
        $lowStockCount = Inventory::where('quantity', '<=', 10)->count();

        $products = Product::all();
        $productNames = $products->pluck('name');
        $productQuantities = $products->map(function($product) {
            return $product->inventories->sum('quantity');
        });

        $historyDates = collect(range(0, 6))->map(function($i) {
            return now()->subDays(6 - $i)->format('Y-m-d');
        });

        $stockAdded = $historyDates->map(function($date) {
            return StockHistory::whereDate('created_at', $date)
                ->where('action', 'add')
                ->get()
                ->sum(function($h) {
                    return $h->quantity_after - $h->quantity_before;
                });
        });

        $stockDeducted = $historyDates->map(function($date) {
            return StockHistory::whereDate('created_at', $date)
                ->where('action', 'deduct')
                ->get()
                ->sum(function($h) {
                    return $h->quantity_before - $h->quantity_after;
                });
        });

        return view('inventory.analytics', compact(
            'totalValue', 'totalProducts', 'lowStockCount',
            'productNames', 'productQuantities',
            'historyDates', 'stockAdded', 'stockDeducted'
        ));
    }

    public function productBatches($productId)
    {
        $product = Product::with('batches')->findOrFail($productId);
        return view('inventory.product_batches', [
            'product' => $product,
        ]);
    }

    public function productSales($productId)
    {
        $product = Product::with('orders.user')->findOrFail($productId);
        $batches = \App\Models\Inventory::where('product_id', $productId)->get();
        $movements = \App\Models\StockHistory::whereIn('inventory_id', $batches->pluck('id'))
            ->orderByDesc('created_at')->get();
        $sales = \App\Models\Order::with(['user'])
            ->where('product_id', $productId)
            ->orderByDesc('created_at')->get();
        return view('inventory.product_batches', compact('product', 'batches', 'movements', 'sales'));
    }
}
