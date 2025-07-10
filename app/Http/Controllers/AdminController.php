<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\Order;

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

        // Batch-level analytics (example, replace with real queries as needed)
        $batchLabels = Product::with('batches')->get()->flatMap(function($product){
            return $product->batches->pluck('batch_id');
        })->unique()->values()->all();
        $batchData = Product::with('batches')->get()->flatMap(function($product){
            return $product->batches->pluck('quantity');
        })->values()->all();

        // Use the correct dashboard view for admin
        return view('dashboards.admin', compact(
            'totalUsers', 'totalProducts', 'totalVendors',
            'totalOrders',  'recentOrders',
            'userRegistrationLabels', 'userRegistrationCounts',
            'revenueTrendLabels', 'revenueTrendData',
            'systemHealth', 'notifications', 'activityLog',
            'batchLabels', 'batchData'
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
        $request->validate([
            'role_as' => 'required|in:0,1,2',
        ]);
        $user = User::findOrFail($id);
        $user->role_as = $request->role_as;
        $user->save();
        return redirect()->route('admin.users')->with('success', 'User role updated successfully.');
    }

    // Show aspiring vendor requests and approved vendors
    public function vendors()
    {
        $aspiringVendors = Vendor::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        $approvedVendors = Vendor::where('status', 'approved')->orderBy('created_at', 'desc')->get();
        return view('admin.vendors', compact('aspiringVendors', 'approvedVendors'));
    }
}
