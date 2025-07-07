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
        return view('dashboard.index');
    }
}
