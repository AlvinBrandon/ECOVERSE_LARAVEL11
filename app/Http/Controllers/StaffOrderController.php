<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PurchaseOrder;

class StaffOrderController extends Controller
{
    /**
     * Staff should only handle wholesaler purchase orders from factories/suppliers
     * NOT retailer or customer orders
     */
    public function index()
    {
        // Only get orders where wholesalers are purchasing from factories
        $wholesalerOrders = Order::with(['user', 'product'])
            ->whereHas('user', function($query) {
                $query->where('role', 'wholesaler')
                      ->orWhere('role_as', 5);
            })
            ->whereHas('product', function($query) {
                $query->where('seller_role', 'factory');
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Also get purchase orders (raw materials from suppliers)
        $purchaseOrders = PurchaseOrder::with(['rawMaterial', 'supplier'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('staff.orders', compact('wholesalerOrders', 'purchaseOrders'));
    }
    
    /**
     * Update status for wholesaler orders only
     */
    public function updateStatus(Request $request, $id)
    {
        // Ensure this is a wholesaler order from factory
        $order = Order::whereHas('user', function($query) {
            $query->where('role', 'wholesaler')
                  ->orWhere('role_as', 5);
        })
        ->whereHas('product', function($query) {
            $query->where('seller_role', 'factory');
        })
        ->findOrFail($id);
        
        $request->validate([
            'status' => 'required|string|in:pending,approved,processing,shipped,delivered,cancelled'
        ]);
        
        $order->status = $request->input('status');
        $order->save();
        
        return redirect()->back()->with('success', 'Wholesaler order status updated successfully');
    }
}
