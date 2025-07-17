<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // $role = Auth::user()->role;

        
        // return match($role) {
        //     'admin' => redirect()->route('admin.dashboard'),
        //     'staff' => redirect()->route('staff.dashboard'),
        //     'supplier' => redirect()->route('supplier.dashboard'),
        //     'retailer' => redirect()->route('retailer.dashboard'),
        //     'wholesaler' => redirect()->route('wholesaler.dashboard'),
        //     'customer' => redirect()->route('customer.dashboard'),
        //     default => abort(403, 'Unauthorized action.'),
        // };
        $user = auth()->user();
        // Allow admin to view customer dashboard with ?as=customer
        if ($user->role_as == 1 && request('as') === 'customer') {
            return view('dashboard.customer');
        }
        if ($user->role_as == 1) {
            // Use AdminController's dashboard method to ensure all variables are passed
            return app(\App\Http\Controllers\AdminController::class)->dashboard();
        } elseif ($user->role_as == 2) {
            return view('vendor.admin');
        } else {
            return view('dashboard.customer');
        }
    }

    public function supplierDashboard()
    {
        $supplier = auth()->user();
        // Demo data for widgets
        $rawMaterials = collect([
            (object)['name' => 'Plastic', 'quantity' => 100],
            (object)['name' => 'Metal', 'quantity' => 50],
        ]);
        $pendingOrders = collect([
            (object)['id' => 1, 'status' => 'pending'],
            (object)['id' => 2, 'status' => 'pending'],
        ]);
        $recentPayments = collect([
            (object)['amount' => 5000, 'created_at' => now()->subDays(2)],
            (object)['amount' => 3000, 'created_at' => now()->subDays(10)],
        ]);
        $activities = collect([
            (object)[
                'created_at' => now()->subHours(1),
                'description' => 'Supplied 100kg Plastic',
                'status' => 'success',
                'details' => 'Order #1'
            ],
            (object)[
                'created_at' => now()->subDays(1),
                'description' => 'Payment received',
                'status' => 'success',
                'details' => '₦5,000'
            ],
            (object)[
                'created_at' => now()->subDays(2),
                'description' => 'Order placed',
                'status' => 'pending',
                'details' => 'Order #2'
            ],
        ]);
        return view('dashboards.supplier', compact('supplier', 'rawMaterials', 'pendingOrders', 'recentPayments', 'activities'));
    }
}
