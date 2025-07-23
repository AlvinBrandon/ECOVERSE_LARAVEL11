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
use App\Events\InventoryUpdated;

class InventoryController extends Controller
{
    // All raw material purchase order prices must be entered and displayed in Ugandan Shillings (UGX).
    // ...existing code...

    /**
     * Show the raw material inventory in a dedicated view.
     */
    public function rawMaterials()
    {
        // Group inventory by raw_material_id and sum quantities, show only one row per raw material
        $rawMaterialInventory = \App\Models\Inventory::with(['rawMaterial'])
            ->whereNotNull('raw_material_id')
            ->get()
            ->groupBy('raw_material_id')
            ->map(function($group) {
                $first = $group->first();
                return (object) [
                    'rawMaterial' => $first->rawMaterial,
                    'quantity' => $group->sum('quantity'),
                    'updated_at' => $group->max('updated_at'),
                ];
            });
        return view('inventory.raw-materials', ['rawMaterialInventory' => $rawMaterialInventory]);
    }

    public function index()
    {
        // Group products and sum their inventory quantities (all batches)
        // ONLY show factory/wholesaler products, NOT retailer products
        $products = Product::with('inventories')
            ->whereIn('seller_role', ['wholesaler', 'admin', 'factory'])
            ->orWhereNull('seller_role')
            ->get();
            
        $productInventory = $products->map(function($product) {
            return [
                'product' => $product,
                'quantity' => $product->inventories->sum('quantity'),
                'updated_at' => $product->inventories->max('updated_at'),
                'product_id' => $product->id,
            ];
        });
        $totalValue = $products->reduce(function ($carry, $product) {
            return $carry + (($product->price ?? 0) * $product->inventories->sum('quantity'));
        }, 0);
        return view('inventory.index', compact('productInventory', 'totalValue'));
    }

    public function create()
    {
        // Only show factory/wholesaler products for inventory management, NOT retailer products
        $products = Product::whereIn('seller_role', ['wholesaler', 'admin', 'factory'])
            ->orWhereNull('seller_role')
            ->get();
        $rawMaterials = RawMaterial::all();
        return view('inventory.create', compact('products', 'rawMaterials'));
    }

    public function store(Request $request)
    {
        // NOTE: All raw material purchase order prices must be in Ugandan Shillings (UGX)
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
            // If price is present, ensure it is numeric and >= 0 (UGX)
            'price' => 'nullable|numeric|min:0',
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
            // Broadcast inventory update event
            event(new InventoryUpdated('add', $request->product_id, $request->batch_id, $request->quantity, Auth::id()));
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
        // Only show factory/wholesaler products for inventory deduction, NOT retailer products
        $products = Product::whereIn('seller_role', ['wholesaler', 'admin', 'factory'])
            ->orWhereNull('seller_role')
            ->get();
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
        // Broadcast inventory update event
        event(new InventoryUpdated('deduct', $inventory->product_id, $inventory->batch_id, $request->quantity, Auth::id()));

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

    public function history(Request $request)
    {
        $query = StockHistory::with(['inventory.product', 'inventory.rawMaterial', 'user']);
        
        // Apply filters
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        
        if ($request->filled('item_type')) {
            if ($request->item_type === 'product') {
                $query->whereHas('inventory', function($q) {
                    $q->whereNotNull('product_id');
                });
            } elseif ($request->item_type === 'raw_material') {
                $query->whereHas('inventory', function($q) {
                    $q->whereNotNull('raw_material_id');
                });
            }
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $histories = $query->latest()->paginate(50);
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
        // Sum all inventory quantities * product price
        // ONLY calculate for factory/wholesaler products, NOT retailer products
        $totalValue = 0;
        $products = Product::with('inventories')
            ->whereIn('seller_role', ['wholesaler', 'admin', 'factory'])
            ->orWhereNull('seller_role')
            ->get();
        foreach ($products as $product) {
            $totalQty = $product->inventories->sum('quantity');
            $totalValue += $totalQty * ($product->price ?? 0);
        }

        $totalProducts = $products->count();
        // Low stock: count products where total quantity across all batches <= 10
        $lowStockCount = $products->filter(function($product) {
            return $product->inventories->sum('quantity') <= 10;
        })->count();

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
