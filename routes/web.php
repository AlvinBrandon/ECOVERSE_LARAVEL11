<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatPollingController;
use App\Http\Controllers\ChatNotificationController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesApprovalController;
use App\Http\Controllers\StaffOrderController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\EcoPointController;
// use App\Http\Controllers\OrderController;

// Admin dashboard route with both 'auth' and 'admin' middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users/{id}/role', [AdminController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::delete('/admin/users/{id}/delete', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    
    // Prediction routes
    Route::get('/admin/predictions', [App\Http\Controllers\Admin\PredictionController::class, 'index'])->name('admin.predictions.dashboard');
    Route::get('/admin/predictions/get', [App\Http\Controllers\Admin\PredictionController::class, 'getPredictions'])->name('admin.predictions.get');
    Route::post('/admin/predictions/train', [App\Http\Controllers\Admin\PredictionController::class, 'train'])->name('admin.predictions.train');
    Route::get('/admin/predictions/insights', [App\Http\Controllers\Admin\PredictionController::class, 'getInsights'])->name('admin.predictions.insights');
    Route::post('/admin/predictions/custom', [App\Http\Controllers\Admin\PredictionController::class, 'getCustomPredictions'])->name('admin.predictions.custom');
});

use App\Http\Controllers\WholesalerReportController;
use App\Http\Controllers\RetailerReportController;
use App\Http\Controllers\Wholesaler\RetailerNetworkController;

// Wholesaler analytics and retailer order verification
Route::middleware(['auth', 'role:wholesaler,5'])->group(function () {
    Route::get('/wholesaler/reports', [WholesalerReportController::class, 'index'])->name('wholesaler.reports');
    Route::get('/wholesaler/retailer-network', [RetailerNetworkController::class, 'index'])->name('wholesaler.retailer-network');
    Route::post('/wholesaler/retailer-network/verify/{order}', [RetailerNetworkController::class, 'verifyOrder'])->name('wholesaler.retailer-network.verify');
    Route::post('/wholesaler/retailer-network/reject/{order}', [RetailerNetworkController::class, 'rejectOrder'])->name('wholesaler.retailer-network.reject');
    Route::post('/wholesaler/retailer-network/bulk-verify', [RetailerNetworkController::class, 'bulkVerify'])->name('wholesaler.retailer-network.bulk-verify');
});

// Retailer analytics and customer order verification
Route::middleware(['auth', 'role:retailer,2'])->get('/retailer/reports', [RetailerReportController::class, 'index'])->name('retailer.reports');

// Retailer customer order verification routes
use App\Http\Controllers\Retailer\CustomerOrderController as RetailerCustomerOrderController;
Route::middleware(['auth', 'role:retailer,2'])->group(function () {
    Route::get('/retailer/customer-orders', [RetailerCustomerOrderController::class, 'index'])->name('retailer.customer-orders');
    Route::post('/retailer/customer-orders/verify/{order}', [RetailerCustomerOrderController::class, 'verify'])->name('retailer.customer-orders.verify');
    Route::post('/retailer/customer-orders/reject/{order}', [RetailerCustomerOrderController::class, 'reject'])->name('retailer.customer-orders.reject');
    Route::post('/retailer/customer-orders/bulk-verify', [RetailerCustomerOrderController::class, 'bulkVerify'])->name('retailer.customer-orders.bulk-verify');
    Route::post('/retailer/customer-orders/dispatch/{order}', [RetailerCustomerOrderController::class, 'dispatch'])->name('retailer.customer-orders.dispatch');
    Route::post('/retailer/customer-orders/mark-delivered/{order}', [RetailerCustomerOrderController::class, 'markDelivered'])->name('retailer.customer-orders.mark-delivered');
});

// Retailer order management routes (legacy)
use App\Http\Controllers\RetailerOrderController;
Route::middleware(['auth', 'role:retailer,2'])->prefix('retailer')->group(function () {
    Route::post('/orders/{order}/approve', [RetailerOrderController::class, 'approveOrder'])->name('retailer.orders.approve');
    Route::post('/orders/{order}/reject', [RetailerOrderController::class, 'rejectOrder'])->name('retailer.orders.reject');
    Route::get('/inventory', [RetailerOrderController::class, 'inventory'])->name('retailer.inventory');
});

// Chat routes
Route::middleware(['auth'])->prefix('chat')->name('chat.')->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('index');
    Route::get('/history/{roomId?}', [ChatController::class, 'history'])->name('history');
    Route::get('/start', [ChatController::class, 'start'])->name('start');
    Route::post('/start', [ChatController::class, 'startChat'])->name('startChat');
    Route::post('/room', [ChatController::class, 'createRoom'])->name('createRoom');
    Route::post('/message', [ChatController::class, 'sendMessage'])->name('sendMessage');
    Route::post('/message/reply', [ChatController::class, 'sendMessage'])->name('replyToMessage');
    Route::post('/message/feedback', [ChatController::class, 'sendAdminFeedback'])->name('sendAdminFeedback')->middleware('role:admin');
    Route::get('/messages/{roomId}', [ChatController::class, 'getMessages'])->name('getMessages');
    Route::post('/messages/{roomId}/read', [ChatController::class, 'markAsRead'])->name('markAsRead');
    Route::post('/status', [ChatController::class, 'updateStatus'])->name('updateStatus');
    Route::get('/demo', [ChatController::class, 'demo'])->name('demo');
    
    // Polling routes
    Route::get('/poll/messages', [ChatPollingController::class, 'getMessages'])->name('poll.messages');
    Route::post('/poll/send', [ChatPollingController::class, 'sendMessage'])->name('poll.sendMessage');
    Route::get('/poll/online-users', [ChatPollingController::class, 'getOnlineUsers'])->name('poll.onlineUsers');
    Route::post('/poll/typing', [ChatPollingController::class, 'setTypingStatus'])->name('poll.setTyping');
    Route::get('/poll/typing-users', [ChatPollingController::class, 'getTypingUsers'])->name('poll.typingUsers');
    Route::get('/poll/unread-count', [ChatPollingController::class, 'getUnreadCount'])->name('poll.unreadCount');
    Route::post('/poll/mark-read', [ChatNotificationController::class, 'markAsRead'])->name('poll.markRead');
});

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockTransferController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RawMaterialController;
use Illuminate\Support\Facades\Auth;

Route::middleware(['auth', 'role:supplier,admin,staff'])->prefix('supplier')->group(function () {
    Route::resource('raw-materials', RawMaterialController::class);
});

Route::middleware(['auth', 'role:admin,staff'])->prefix('inventory')->group(function () {
    Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/raw-materials', [InventoryController::class, 'rawMaterials'])->name('inventory.raw-materials');
    Route::get('/add', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/store', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/deduct', [InventoryController::class, 'deductForm'])->name('inventory.deductForm');
    Route::post('/deduct', [InventoryController::class, 'deduct'])->name('inventory.deduct');
    Route::get('/history', [InventoryController::class, 'history'])->name('inventory.history');
    Route::get('/export/csv', [InventoryController::class, 'export'])->name('inventory.export.csv');
    Route::get('/analytics', [InventoryController::class, 'analytics'])->name('inventory.analytics');
    Route::get('/inventory/product/{product}/batches', [InventoryController::class, 'productSales'])->name('inventory.product.batches');
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

// Stock transfer for admin/staff only
Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::get('/stock-transfer', [StockTransferController::class, 'create'])->name('stock_transfer.create');
    Route::post('/stock-transfer', [StockTransferController::class, 'store'])->name('stock_transfer.store');
});

// Customer management - Only for retailers (since customers buy from retailers)
Route::middleware(['auth', 'role:retailer'])->group(function () {
    Route::get('/customers/analytics', [CustomerController::class, 'analytics'])->name('customers.analytics');
    Route::resource('customers', CustomerController::class);
});

Route::get('/dashboard', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        // dd($role);
        switch ($role) {
            case 'admin':
                return app(\App\Http\Controllers\AdminController::class)->dashboard();
            case 'supplier':
                $data = \App\Http\Controllers\PurchaseOrderController::supplierDashboardData(Auth::id());
                return view('dashboards.supplier', $data);
            case 'staff':
                return view('dashboards.staff');
            case 'retailer':
                return app(\App\Http\Controllers\DashboardController::class)->retailerDashboard();
            case 'wholesaler':
                return app(\App\Http\Controllers\DashboardController::class)->wholesalerDashboard();
            default:
                return app(\App\Http\Controllers\DashboardController::class)->customerDashboard();
        }
    }
    return redirect()->route('login');
})->middleware('auth')->name('dashboard');

Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');

Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');

Route::post('sign-in', function (\Illuminate\Http\Request $request) {
    $response = app(App\Http\Controllers\SessionsController::class)->store($request);
    // After login, redirect to dashboard for all roles
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return $response;
})->middleware('guest');

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
Route::put('profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');
Route::get('profile/settings', [ProfileController::class, 'settings'])->middleware('auth')->name('profile.settings');
Route::get('orders', [CustomerOrderController::class, 'index'])->middleware('auth')->name('orders.index');
Route::get('support', function () {
    return view('pages.support');
})->middleware('auth')->name('support');
Route::group(['middleware' => 'auth'], function () {
    Route::get('billing', function () {
        return view('pages.billing');
    Route::delete('/admin/users/{id}/delete', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
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
        return redirect()->route('admin.users.index');
    })->name('user-management');
    Route::get('user-profile', function () {
        return view('pages.laravel-examples.user-profile');
    })->name('user-profile');
});

// Vendor Validation Feature
require_once __DIR__.'/orders_verify.php';
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
    Route::get('/products/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/sales/verify', [SalesApprovalController::class, 'index'])->name('admin.sales.pending');
    Route::post('/sales/{id}/verify', [SalesApprovalController::class, 'verify'])->name('admin.sales.verify');
    Route::post('/sales/{id}/reject', [SalesApprovalController::class, 'reject'])->name('admin.sales.reject');
    Route::post('/sales/bulk-verify', [SalesApprovalController::class, 'bulkVerify'])->name('admin.sales.bulk-verify');
    
    // Analytics & Reports
    Route::get('/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('admin.analytics');
    Route::get('/analytics/export', [\App\Http\Controllers\Admin\AnalyticsController::class, 'export'])->name('admin.analytics.export');
});

// Purchase Order Workflow Routes

// Admin and Staff routes for purchase orders
Route::middleware(['auth', 'role:admin,staff'])->prefix('admin')->group(function () {
    Route::get('/purchase-orders', [App\Http\Controllers\PurchaseOrderController::class, 'adminIndex'])->name('admin.purchase_orders.index');
    Route::get('/purchase-orders/create', [App\Http\Controllers\PurchaseOrderController::class, 'create'])->name('admin.purchase_orders.create');
    Route::post('/purchase-orders', [App\Http\Controllers\PurchaseOrderController::class, 'store'])->name('admin.purchase_orders.store');
    Route::post('/purchase-orders/{purchaseOrder}/verify', [App\Http\Controllers\PurchaseOrderController::class, 'verify'])->name('admin.purchase_orders.verify');
    Route::post('/purchase-orders/{purchaseOrder}/mark-paid', [App\Http\Controllers\PurchaseOrderController::class, 'markPaid'])->name('admin.purchase_orders.markPaid');
    Route::get('/purchase-orders/{purchaseOrder}', [App\Http\Controllers\PurchaseOrderController::class, 'show'])->name('admin.purchase_orders.show');
    
    // Admin User Management Routes
    Route::resource('users', App\Http\Controllers\AdminUserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
});

// Supplier routes for purchase orders
Route::middleware(['auth', 'role:supplier'])->prefix('supplier')->group(function () {
    Route::get('/purchase-orders', [App\Http\Controllers\PurchaseOrderController::class, 'supplierIndex'])->name('supplier.purchase_orders.index');
    Route::get('/purchase-orders/{purchaseOrder}', [App\Http\Controllers\PurchaseOrderController::class, 'show'])->name('supplier.purchase_orders.show');
    Route::post('/purchase-orders/{purchaseOrder}/deliver', [App\Http\Controllers\PurchaseOrderController::class, 'deliver'])->name('supplier.purchase_orders.deliver');
    Route::post('/purchase-orders/{purchaseOrder}/mark-delivered', [App\Http\Controllers\PurchaseOrderController::class, 'markDelivered'])->name('supplier.purchase_orders.markDelivered');
});

Route::get('/admin/vendors', [AdminController::class, 'vendors'])->name('admin.vendors');

Route::middleware(['auth', 'role:staff'])->group(function(){
    Route::get('/staff/orders',[StaffOrderController::class, 'index'])->name('staff.orders');
    Route::post('/staff/orders/update-status/{id}', [StaffOrderController::class, 'updateStatus'])->name('staff.orders.updateStatus');
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/my-orders', [CustomerOrderController::class, 'index'])->name('customer.orders');
});
Route::get('/order/{product}', [SalesController::class, 'showOrderForm'])->name('order.form');
Route::post('/order/place', [SalesController::class, 'placeOrder'])->name('order.place');

// Order verification routes for retailers and wholesalers
Route::middleware(['auth', 'role:retailer,wholesaler,admin'])->group(function () {
    Route::post('/orders/{order}/verify', [SalesController::class, 'verifyOrder'])->name('orders.verify');
    Route::post('/orders/{order}/reject', [SalesController::class, 'rejectOrder'])->name('orders.reject');
});

//Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
// web.php

// Step 1: Form submission from product or cart
//Route::post('/order/preview', [OrderController::class, 'preview'])->name('order.preview');

// Step 2: Confirm final order placement
//Route::post('/order/confirm', [OrderController::class, 'confirm'])->name('order.confirm');

// Cart routes
Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
});

Route::get('/order/confirmation', [App\Http\Controllers\CartController::class, 'confirmation'])->name('order.confirmation');
Route::post('/help/request', [App\Http\Controllers\HelpController::class, 'request'])->name('help.request');

// Eco-Points Redemption System Routes
Route::middleware(['auth'])->prefix('eco-points')->name('eco-points.')->group(function () {
    Route::get('/rewards', [EcoPointController::class, 'rewards'])->name('rewards');
    Route::get('/history', [EcoPointController::class, 'history'])->name('history');
    Route::post('/redeem/{reward}', [EcoPointController::class, 'redeem'])->name('redeem');
    Route::get('/voucher/{voucherCode}', [EcoPointController::class, 'voucher'])->name('voucher');
    Route::get('/balance', [EcoPointController::class, 'balance'])->name('balance');
});

// Voucher validation for checkout process
Route::middleware(['auth'])->group(function () {
    Route::post('/voucher/validate', [EcoPointController::class, 'validateVoucher'])->name('voucher.validate');
});

// TEMP: Route to clear cart session for development
Route::get('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
