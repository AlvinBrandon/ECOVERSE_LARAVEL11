<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SalesApprovalController extends Controller
{
    public function index()
    {
        // Admins should only verify orders from wholesalers (buying from factories)
        $sales = Order::with(['user', 'product'])
            ->where('status', 'pending')
            ->whereHas('user', function($query) {
                $query->where('role', 'wholesaler')
                      ->orWhere('role_as', 5);
            })
            ->latest()
            ->get();

        return view('admin.verify', compact('sales'));
    }

    public function verify($id)
    {
        $sale = Order::findOrFail($id);
        $product = $sale->product;

        // Save delivery/dispatch fields if present
        $sale->delivery_status = request('delivery_status', $sale->delivery_status);
        $sale->tracking_code = request('tracking_code', $sale->tracking_code);
        $sale->dispatch_log = request('dispatch_log', $sale->dispatch_log);

        // If the buyer is a wholesaler, update seller_role and inventory for retailer visibility
        if ($sale->user && (isset($sale->user->role_as) ? $sale->user->role_as == 5 : $sale->user->role === 'wholesaler')) {
            $product->seller_role = 'wholesaler';
            $product->save();
            
            // Calculate total available inventory across all records
            $totalAvailableStock = $product->inventories()->sum('quantity');
            
            // Check if sufficient total stock is available
            if ($totalAvailableStock >= $sale->quantity) {
                // Deduct from inventory records starting with the ones with highest stock
                $inventories = $product->inventories()->where('quantity', '>', 0)->orderBy('quantity', 'desc')->get();
                $remainingToDeduct = $sale->quantity;
                
                foreach ($inventories as $inventory) {
                    if ($remainingToDeduct <= 0) break;
                    
                    $quantityBefore = $inventory->quantity;
                    $deductFromThis = min($inventory->quantity, $remainingToDeduct);
                    $inventory->quantity -= $deductFromThis;
                    $remainingToDeduct -= $deductFromThis;
                    $inventory->save();
                    
                    // Create stock history record for each deduction
                    \App\Models\StockHistory::create([
                        'inventory_id' => $inventory->id,
                        'user_id' => Auth::id(),
                        'action' => 'deduct',
                        'quantity_before' => $quantityBefore,
                        'quantity_after' => $inventory->quantity,
                        'note' => 'Stock deducted for wholesaler order #' . $sale->id . ' approval by admin (partial: ' . $deductFromThis . ' units)',
                    ]);
                }
            } else {
                return back()->with('error', 'Insufficient stock available. Only ' . $totalAvailableStock . ' units in stock, but order requires ' . $sale->quantity . ' units.');
            }
            
            // Wholesaler orders should only deduct from factory inventory
            // No need to create separate "retailer inventory" records
        }
        // If the buyer is a retailer, create retailer-specific inventory (NOT duplicate products)
        elseif ($sale->user && (isset($sale->user->role_as) ? $sale->user->role_as == 2 : $sale->user->role === 'retailer')) {
            // Instead of creating duplicate products, create retailer-specific inventory
            $retailerInventory = $product->inventories()->where('owner_id', $sale->user->id)->first();
            
            if ($retailerInventory) {
                // Update existing retailer inventory
                $before = $retailerInventory->quantity;
                $retailerInventory->quantity += $sale->quantity;
                $retailerInventory->save();
            } else {
                // Create new retailer inventory for the SAME product
                $retailerInventory = $product->inventories()->create([
                    'quantity' => $sale->quantity,
                    'batch_id' => 'RTL-' . uniqid(),
                    'owner_id' => $sale->user->id,
                    'owner_type' => 'retailer',
                    'retail_markup' => 0.20, // 20% markup for retail
                    'expiry_date' => null,
                ]);
                $before = 0;
            }
            
            // Create stock history for retailer inventory
            \App\Models\StockHistory::create([
                'inventory_id' => $retailerInventory->id,
                'user_id' => $sale->user->id,
                'action' => 'add',
                'quantity_before' => $before,
                'quantity_after' => $retailerInventory->quantity,
                'note' => 'Stock added from wholesaler order #' . $sale->id . ' approval',
            ]);
        }

        $sale->status = 'approved';
        $sale->save();

        $currentUser = Auth::user();
        if (($currentUser && isset($currentUser->role) && $currentUser->role === 'wholesaler') || ($currentUser && isset($currentUser->role_as) && $currentUser->role_as == 5)) {
            return redirect()->route('wholesaler.reports')->with('success', 'Order verified, product now available to customers.');
        }
        if (($currentUser && isset($currentUser->role) && $currentUser->role === 'retailer') || ($currentUser && isset($currentUser->role_as) && $currentUser->role_as == 2)) {
            return redirect()->route('retailer.reports')->with('success', 'Order verified, product now available to customers.');
        }
        return redirect()->route('admin.sales.report')->with('success', 'Order verified, product now available to retailers.');
    }

    public function reject($id)
    {
        $sale = Order::findOrFail($id);
        $sale->status = 'rejected';
        $sale->save();

        $currentUser = Auth::user();
        if (($currentUser && isset($currentUser->role) && $currentUser->role === 'wholesaler') || ($currentUser && isset($currentUser->role_as) && $currentUser->role_as == 5)) {
            return redirect()->route('wholesaler.reports')->with('success', 'Order rejected.');
        }
        if (($currentUser && isset($currentUser->role) && $currentUser->role === 'retailer') || ($currentUser && isset($currentUser->role_as) && $currentUser->role_as == 2)) {
            return redirect()->route('retailer.reports')->with('success', 'Order rejected.');
        }
        return back()->with('success', 'Order rejected.');
    }

    public function bulkVerify(Request $request)
    {
        $request->validate([
            'selected_sales' => 'required|string',
            'bulk_delivery_status' => 'required|in:pending,dispatched,delivered,pickup_arranged',
            'bulk_tracking_prefix' => 'nullable|string|max:20',
            'bulk_dispatch_log' => 'nullable|string|max:255',
        ]);

        $saleIds = explode(',', $request->selected_sales);
        $sales = Order::whereIn('id', $saleIds)->with(['user', 'product'])->get();

        if ($sales->isEmpty()) {
            return back()->with('error', 'No valid sales found for bulk verification.');
        }

        $verifiedCount = 0;
        $totalValue = 0;
        $wholesalerOrders = [];

        foreach ($sales as $sale) {
            $product = $sale->product;
            if (!$product) continue;

            // Calculate total value with role-based pricing
            $unitPrice = $product->getPriceForUser($sale->user) ?? $product->price;
            $totalValue += $unitPrice * $sale->quantity;

            // Generate unique tracking code
            $trackingCode = $request->bulk_tracking_prefix 
                ? $request->bulk_tracking_prefix . date('Ymd') . '-' . $sale->id
                : 'TRK-' . date('Ymd') . '-' . $sale->id;

            // Update sale details
            $sale->delivery_status = $request->bulk_delivery_status;
            $sale->tracking_code = $trackingCode;
            $sale->dispatch_log = $request->bulk_dispatch_log ?? 'Bulk verified on ' . now()->format('Y-m-d H:i:s');

            // Special handling for wholesaler orders
            if ($sale->user && (isset($sale->user->role_as) ? $sale->user->role_as == 5 : $sale->user->role === 'wholesaler')) {
                $product->seller_role = 'wholesaler';
                $product->save();

                // Track wholesaler orders for summary
                $userName = $sale->user->name;
                if (!isset($wholesalerOrders[$userName])) {
                    $wholesalerOrders[$userName] = ['count' => 0, 'total' => 0];
                }
                $wholesalerOrders[$userName]['count']++;
                $wholesalerOrders[$userName]['total'] += $unitPrice * $sale->quantity;

                // Handle inventory - use total stock calculation
                $totalAvailableStock = $product->inventories()->sum('quantity');
                
                if ($totalAvailableStock >= $sale->quantity) {
                    // Deduct from inventory records starting with the ones with highest stock
                    $inventories = $product->inventories()->where('quantity', '>', 0)->orderBy('quantity', 'desc')->get();
                    $remainingToDeduct = $sale->quantity;
                    
                    foreach ($inventories as $inventory) {
                        if ($remainingToDeduct <= 0) break;
                        
                        $deductFromThis = min($inventory->quantity, $remainingToDeduct);
                        $inventory->quantity -= $deductFromThis;
                        $remainingToDeduct -= $deductFromThis;
                        $inventory->save();
                    }
                } else {
                    // Skip this order if insufficient stock
                    continue;
                }

                // Wholesaler orders only deduct from factory inventory
                // No additional "retailer inventory" should be created
            }

            $sale->status = 'approved';
            $sale->save();
            $verifiedCount++;
        }

        // Create success message with summary
        $message = "Successfully verified {$verifiedCount} orders with total value of UGX " . number_format($totalValue, 2);
        
        if (!empty($wholesalerOrders)) {
            $message .= ". Wholesaler orders processed: ";
            $summaries = [];
            foreach ($wholesalerOrders as $name => $data) {
                $summaries[] = "{$name} ({$data['count']} orders, UGX " . number_format($data['total'], 2) . ")";
            }
            $message .= implode(', ', $summaries);
        }

        return back()->with('success', $message);
    }
}
