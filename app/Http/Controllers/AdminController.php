<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\Order;
use App\Models\PurchaseOrder;
use App\Models\RawMaterial;
use App\Models\StockHistory;
use Illuminate\Support\Facades\Auth;
use App\Events\UserRoleChanged;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalVendors = Vendor::count();
        $totalOrders = Order::count();
        // $totalRevenue = Order::sum('total_price');
        $recentOrders = Order::with('user', 'product')->latest()->take(5)->get();

        // User registrations for the last 7 days
        $userRegistrationLabels = [];
        $userRegistrationCounts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $userRegistrationLabels[] = now()->subDays($i)->format('D');
            $userRegistrationCounts[] = User::whereDate('created_at', $date)->count();
        }

        // Revenue trend for the last 7 days
        $revenueTrendLabels = [];
        $revenueTrendData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $revenueTrendLabels[] = now()->subDays($i)->format('D');
            // $revenueTrendData[] = Order::whereDate('created_at', $date)->sum('total_price');
        }

        // System Health (example, replace with real checks as needed)
        $systemHealth = [
            'server' => 'Online',
            'queue' => 'Running',
            'storage' => '80% used',
            'last_backup' => 'Today, 2:00 AM',
        ];

        // Notifications (example, replace with real queries as needed)
        $notifications = [
            ['type' => 'danger', 'icon' => 'exclamation-circle', 'text' => 'Low stock: ' . (Product::whereHas('batches', function($q){$q->where('quantity', '<', 10);})->first()->name ?? 'None')],
            ['type' => 'success', 'icon' => 'person-plus', 'text' => 'New user registered: ' . (User::latest()->first()->name ?? 'N/A')],
            ['type' => 'info', 'icon' => 'check-circle', 'text' => 'Sale #' . (Order::latest()->first()->id ?? 'N/A') . ' approved'],
            ['type' => 'warning', 'icon' => 'archive', 'text' => 'Inventory batch expiring soon'],
        ];

        // Activity Log (example, replace with real queries as needed)
        $activityLog = [
            ['type' => 'success', 'icon' => 'person-check', 'text' => 'Admin approved sale #' . (Order::where('status', 'verified')->latest()->first()->id ?? 'N/A')],
            ['type' => 'primary', 'icon' => 'pencil-square', 'text' => 'Product ' . (Product::latest()->first()->name ?? 'N/A') . ' updated'],
            ['type' => 'warning', 'icon' => 'archive', 'text' => 'Inventory batch added'],
            ['type' => 'danger', 'icon' => 'trash', 'text' => 'User ' . (User::latest()->first()->name ?? 'N/A') . ' deleted batch'],
        ];

        // Batch-level analytics - group by product names instead of batch IDs
        $productInventory = Product::with('batches')->get()->map(function($product) {
            $totalQuantity = $product->batches->sum('quantity');
            return [
                'name' => $product->name,
                'quantity' => $totalQuantity
            ];
        })->filter(function($item) {
            return $item['quantity'] > 0; // Only show products with inventory
        });
        
        // If no products with batches, show regular product inventory
        if ($productInventory->isEmpty()) {
            $productInventory = Product::where('stock', '>', 0)->get()->map(function($product) {
                return [
                    'name' => $product->name,
                    'quantity' => $product->stock
                ];
            })->take(10); // Limit to top 10 products
        }
        
        $batchLabels = $productInventory->pluck('name')->all();
        $batchData = $productInventory->pluck('quantity')->all();
        
        // Fallback data if still empty
        if (empty($batchLabels)) {
            $batchLabels = ['No Products Available'];
            $batchData = [1];
        }

        // --- Raw Material & PO Dashboard Data ---
        $adminPOs = PurchaseOrder::with(['rawMaterial', 'supplier'])
            ->orderByDesc('created_at')->take(10)->get();
        $pendingDeliveries = PurchaseOrder::with(['rawMaterial', 'supplier'])
            ->where('status', 'delivered')->orderByDesc('delivered_at')->take(10)->get();
        $rawMaterials = RawMaterial::all();
        $supplierPayments = PurchaseOrder::with('supplier')
            ->whereIn('status', ['complete', 'paid'])
            ->get()
            ->groupBy('supplier_id')
            ->map(function($orders, $supplierId) {
                $amount = $orders->sum('price');
                $status = $orders->contains('status', 'paid') ? 'paid' : 'pending';
                return [
                    'supplier' => $orders->first()->supplier->name ?? 'N/A',
                    'amount' => $amount,
                    'status' => $status,
                ];
            })->values();
        $invoices = PurchaseOrder::whereNotNull('invoice_path')->get()->map(function($po) {
            return (object)[
                'po_id' => $po->id,
                'invoice_path' => $po->invoice_path,
                'status' => $po->status,
                'feedback' => null, // Placeholder for future feedback
            ];
        });
        $analytics = [
            'received_this_month' => PurchaseOrder::whereMonth('completed_at', now()->month)->where('status', 'complete')->sum('quantity'),
            'pending_pos' => PurchaseOrder::where('status', 'pending')->count(),
            'pending_deliveries' => PurchaseOrder::where('status', 'delivered')->count(),
            'unpaid' => PurchaseOrder::where('status', 'complete')->count(),
            // Enhanced sales analytics
            'total_sales_this_month' => \App\Models\Order::join('products', 'orders.product_id', '=', 'products.id')
                ->where('orders.status', 'approved')
                ->whereMonth('orders.created_at', now()->month)
                ->sum(\DB::raw('products.price * orders.quantity')),
            'total_revenue_all_time' => \App\Models\Order::join('products', 'orders.product_id', '=', 'products.id')
                ->where('orders.status', 'approved')
                ->sum(\DB::raw('products.price * orders.quantity')),
            'orders_this_week' => \App\Models\Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'top_selling_product' => \App\Models\Order::join('products', 'orders.product_id', '=', 'products.id')
                ->select('products.name', \DB::raw('SUM(orders.quantity) as total_sold'))
                ->where('orders.status', 'approved')
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('total_sold')
                ->first(),
        ];

        // Pending sales count for verification widget
        $pendingSalesCount = \App\Models\Order::where('status', 'pending')->count();

        // Use the correct dashboard view for admin
        return view('dashboards.admin', compact(
            'totalUsers', 'totalProducts', 'totalVendors',
            'totalOrders',  'recentOrders',
            'userRegistrationLabels', 'userRegistrationCounts',
            'revenueTrendLabels', 'revenueTrendData',
            'systemHealth', 'notifications', 'activityLog',
            'batchLabels', 'batchData',
            // New for dashboard widgets:
            'adminPOs', 'pendingDeliveries', 'rawMaterials', 'supplierPayments', 'invoices', 'analytics',
            'pendingSalesCount'
        ));
    }

    // Show all users and their roles
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    // Update a user's role
    public function updateRole(Request $request, $id)
    {
        $roleMap = [
            0 => 'customer',
            1 => 'admin',
            2 => 'retailer',
            3 => 'staff',
            4 => 'supplier',
            5 => 'wholesaler',
        ];
        $request->validate([
            'role_as' => 'required|in:0,1,2,3,4,5',
        ]);
        
        $user = User::findOrFail($id);
        $oldRole = $user->role_as;
        $oldRoleName = $roleMap[$oldRole] ?? 'customer';
        $newRoleName = $roleMap[$request->role_as] ?? 'customer';
        
        $user->role_as = $request->role_as;
        $user->role = $newRoleName;
        $user->save();
        
        // Fire event for role change
        event(new UserRoleChanged($user, $oldRoleName, $newRoleName));
        
        // Clear any cached user data
        $user->refreshRole();
        
        // Clear Laravel cache for user-specific data
        \Cache::forget("user_dashboard_{$user->id}");
        \Cache::forget("user_permissions_{$user->id}");
        
        // If updating current logged-in user, redirect to new dashboard
        if (Auth::id() === $user->id) {
            session()->flash('success', 'Your role has been updated. You are now viewing your new dashboard.');
            return redirect()->route('dashboard');
        }
        
        return redirect()->route('admin.users')->with('success', 
            "User role updated from {$oldRoleName} to {$newRoleName} successfully. The user will see their new dashboard on next login.");
    }

    // Show aspiring vendor requests and approved vendors
    public function vendors()
    {
        $aspiringVendors = Vendor::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        $approvedVendors = Vendor::where('status', 'approved')->orderBy('created_at', 'desc')->get();
        return view('admin.vendors', compact('aspiringVendors', 'approvedVendors'));
    }

    // Delete a user by ID
    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('success', 'User not found.');
        }
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
