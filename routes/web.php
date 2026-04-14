<?php

use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Gudang\DashboardController as GudangDashboardController;
use App\Http\Controllers\Gudang\HistoryController;
use App\Http\Controllers\Gudang\ItemController as GudangItemController;
use App\Http\Controllers\Gudang\StockInController;
use App\Http\Controllers\Gudang\StockOutController;
use App\Http\Controllers\Logistik\AlertController;
use App\Http\Controllers\Logistik\DashboardController as LogistikDashboardController;
use App\Http\Controllers\Logistik\PredictionController as LogistikPredictionController;
use App\Http\Controllers\Logistik\PurchaseOrderController;
use App\Http\Controllers\Manager\ApprovalController;
use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\ExportController;
use App\Http\Controllers\Manager\PredictionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'manager') {
        return redirect()->route('manager.dashboard');
    } elseif ($user->role === 'staff_gudang') {
        return redirect()->route('gudang.dashboard');
    } elseif ($user->role === 'staff_logistik') {
        return redirect()->route('logistik.dashboard');
    }

    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'manager') {
        return redirect()->route('manager.dashboard');
    } elseif ($user->role === 'staff_gudang') {
        return redirect()->route('gudang.dashboard');
    } elseif ($user->role === 'staff_logistik') {
        return redirect()->route('logistik.dashboard');
    }

    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/items', [ItemController::class, 'index'])->name('items');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::put('/items/{material}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{material}', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::get('/logs', [LogController::class, 'index'])->name('logs');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

// Manager Routes
Route::middleware(['auth', 'role:manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/prediction', [PredictionController::class, 'index'])->name('prediction');
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals');
    Route::get('/approvals/{po}', [ApprovalController::class, 'show'])->name('approvals.show');
    Route::post('/approvals/{po}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('/approvals/{po}/reject', [ApprovalController::class, 'reject'])->name('approvals.reject');
    Route::post('/approvals/bulk-approve', [ApprovalController::class, 'bulkApprove'])->name('approvals.bulk-approve');
    Route::get('/export', [ExportController::class, 'index'])->name('export');
    Route::get('/export/download', [ExportController::class, 'download'])->name('export.download');
});

// Gudang Routes
Route::middleware(['auth', 'role:staff_gudang'])->prefix('gudang')->name('gudang.')->group(function () {
    Route::get('/dashboard', [GudangDashboardController::class, 'index'])->name('dashboard');
    Route::get('/stock-in', [StockInController::class, 'index'])->name('stock-in');
    Route::post('/stock-in', [StockInController::class, 'store'])->name('stock-in.store');
    Route::get('/stock-out', [StockOutController::class, 'index'])->name('stock-out');
    Route::post('/stock-out', [StockOutController::class, 'store'])->name('stock-out.store');
    Route::get('/items', [GudangItemController::class, 'index'])->name('items');
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
});

// Logistik Routes
Route::middleware(['auth', 'role:staff_logistik'])->prefix('logistik')->name('logistik.')->group(function () {
    Route::get('/dashboard', [LogistikDashboardController::class, 'index'])->name('dashboard');
    Route::get('/prediction', [LogistikPredictionController::class, 'index'])->name('prediction');
    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts');
    Route::post('/alerts/{alert}/resolve', [AlertController::class, 'resolve'])->name('alerts.resolve');
    Route::post('/alerts/bulk-resolve', [AlertController::class, 'bulkResolve'])->name('alerts.bulk-resolve');
    Route::get('/po', [PurchaseOrderController::class, 'index'])->name('po');
    Route::post('/po', [PurchaseOrderController::class, 'store'])->name('po.store');
    Route::get('/po/{po}', [PurchaseOrderController::class, 'show'])->name('po.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
