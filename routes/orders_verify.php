<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesApprovalController;

Route::middleware(['auth', 'role:retailer,2,wholesaler,5'])->group(function () {
    Route::post('/orders/{id}/verify', [SalesApprovalController::class, 'verify'])->name('orders.verify');
    Route::post('/orders/{id}/reject', [SalesApprovalController::class, 'reject'])->name('orders.reject');
});
