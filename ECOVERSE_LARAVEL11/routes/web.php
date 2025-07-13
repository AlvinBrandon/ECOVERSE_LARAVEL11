<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;

// Admin dashboard route with both 'auth' and 'admin' middleware
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users/{id}/role', [AdminController::class, 'updateRole'])->name('admin.users.updateRole');
});

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockTransferController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RawMaterialController;
use Illuminate\Support\Facades\Auth;

Route::middleware(['auth', 'role:supplier,admin,staff'])->prefix('supplier')->group(function () {
    Route::resource('raw-materials', RawMaterialController::class);
    Route::resource('orders', \App\Http\Controllers\OrderController::class);
    Route::resource('payments', \App\Http\Controllers\PaymentController::class);
});

Route::middleware(['auth', 'role:admin,staff'])->prefix('inventory')->group(function () {
    Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/add', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/store', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/deduct', [InventoryController::class, 'deductForm'])->name('inventory.deductForm');
    Route::post('/deduct', [InventoryController::class, 'deduct'])->name('inventory.deduct');
    Route::get('/history', [InventoryController::class, 'history'])->name('inventory.history');
    Route::get('/export/csv', [InventoryController::class, 'export'])->name('inventory.export.csv');
    Route::get('/analytics', [InventoryController::class, 'analytics'])->name('inventory.analytics');
});

Route::middleware(['auth', 'role:admin,staff,retailer,wholesaler,customer'])->group(function () {
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::post('/sales', [SalesController::class, 'store'])->name('sales.store');
    Route::get('/sales/history', [SalesController::class, 'history'])->name('sales.history');
    Route::get('/sales/status', [SalesController::class, 'status'])->name('sales.status');
    Route::get('/sales/analytics', [SalesController::class, 'analytics'])->name('sales.analytics');
    Route::get('/sales/{id}/invoice', [SalesController::class, 'invoice'])->name('sales.invoice');
});

Route::middleware(['auth', 'role:admin'])->get('/admin/sales-report', [SalesController::class, 'report'])->name('admin.sales.report');


Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::get('/stock-transfer', [StockTransferController::class, 'create'])->name('stock_transfer.create');
    Route::post('/stock-transfer', [StockTransferController::class, 'store'])->name('stock_transfer.store');
    Route::resource('customers', CustomerController::class);
});

Route::get('/dashboard', function () {
    return view('dashboards.supplier', [
        'supplier' => auth()->user(),
        'rawMaterials' => collect([
            (object)['id' => 1, 'name' => 'Plastic', 'quantity' => 100],
            (object)['id' => 2, 'name' => 'Metal', 'quantity' => 50],
        ]),
        'pendingOrders' => collect([
            (object)['id' => 1, 'product' => 'Plastic', 'quantity' => 100, 'status' => 'pending'],
            (object)['id' => 2, 'product' => 'Metal', 'quantity' => 50, 'status' => 'pending'],
        ]),
        'recentPayments' => collect([
            (object)['id' => 1, 'amount' => 500, 'status' => 'completed', 'date' => now()->subDays(1)],
            (object)['id' => 2, 'amount' => 200, 'status' => 'pending', 'date' => now()->subDays(3)],
        ]),
        'activities' => collect([
            (object)[
                'id' => 1,
                'description' => 'Supplied 100 units of Plastic',
                'created_at' => now()->subDays(1),
                'status' => 'success',
                'details' => 'Order #1 fulfilled'
            ],
            (object)[
                'id' => 2,
                'description' => 'Received payment of $500',
                'created_at' => now()->subDays(2),
                'status' => 'success',
                'details' => 'Payment for Order #1'
            ],
            (object)[
                'id' => 3,
                'description' => 'Order #2 pending',
                'created_at' => now()->subDays(3),
                'status' => 'pending',
                'details' => 'Awaiting delivery'
            ],
        ]),
    ]);
})->middleware(['auth'])->name('dashboard');
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');

Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');
Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () {
	return view('sessions.password.verify');
})->middleware('guest')->name('verify'); 
Route::get('/reset-password/{token}', function ($token) {
	return view('sessions.password.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('billing', function () {
		return view('pages.billing');
	})->name('billing');
	Route::get('tables', function () {
		return view('pages.tables');
	})->name('tables');
	Route::get('rtl', function () {
		return view('pages.rtl');
	})->name('rtl');
	Route::get('virtual-reality', function () {
		return view('pages.virtual-reality');
	})->name('virtual-reality');
	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');
	Route::get('static-sign-in', function () {
		return view('pages.static-sign-in');
	})->name('static-sign-in');
	Route::get('static-sign-up', function () {
		return view('pages.static-sign-up');
	})->name('static-sign-up');
	Route::get('user-management', function () {
		return redirect()->route('admin.users');
	})->name('user-management');
	Route::get('user-profile', function () {
		return view('pages.laravel-examples.user-profile');
	})->name('user-profile');
});

// Vendor Validation Feature
Route::get('/vendor/apply', [VendorController::class, 'showApplicationForm'])->name('vendor.apply');
Route::post('/vendor/apply', [VendorController::class, 'submitApplication'])->name('vendor.submit');
Route::get('/admin/vendors', [VendorController::class, 'listApplications'])->middleware('auth')->name('vendor.admin');
Route::get('/admin/vendors/{id}', [VendorController::class, 'showApplication'])->middleware('auth')->name('vendor.show');
Route::post('/admin/vendors/{id}/approve', [VendorController::class, 'approve'])->middleware('auth')->name('vendor.approve');
Route::post('/admin/vendors/{id}/reject', [VendorController::class, 'reject'])->middleware('auth')->name('vendor.reject');

Route::middleware(['auth'])->group(function () {
    Route::get('/vendor/status', [App\Http\Controllers\VendorController::class, 'showStatus'])->name('vendor.status');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
});

Route::get('/admin/vendors', [AdminController::class, 'vendors'])->name('admin.vendors');

Route::middleware(['auth'])->get('/supplier/dashboard', [\App\Http\Controllers\DashboardController::class, 'supplierDashboard'])->name('supplier.dashboard');
