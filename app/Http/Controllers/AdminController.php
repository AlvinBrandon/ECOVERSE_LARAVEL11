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
        $totalRevenue = Order::sum('total_price');
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
            $revenueTrendData[] = Order::whereDate('created_at', $date)->sum('total_price');
        }

        return view('admin.admin', compact(
            'totalUsers', 'totalProducts', 'totalVendors',
            'totalOrders', 'totalRevenue', 'recentOrders',
            'userRegistrationLabels', 'userRegistrationCounts',
            'revenueTrendLabels', 'revenueTrendData'
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
