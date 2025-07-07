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
}
