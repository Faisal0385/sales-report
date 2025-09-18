<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('client.company-page.company-page');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';



Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('client.dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/sales', function () {
//     return view('client.sales-page.sales-page');
// })->middleware(['auth', 'verified'])->name('sales.page');

## Settings
Route::get('/settings/page', [SettingController::class, 'index'])->middleware(['auth', 'verified'])->name('settings.page');
Route::post('/settings/store', [SettingController::class, 'store'])->middleware(['auth', 'verified'])->name('settings.store');
// Route::post('/settings/destroy/{id}', [SalesController::class, 'destroy'])->middleware(['auth', 'verified'])->name('settings.destroy');
// Route::get('/settings/download', [SalesController::class, 'downloadCsv'])->name('settings.download');


## Sales
Route::get('/sales/page', [SalesController::class, 'index'])->middleware(['auth', 'verified'])->name('sales.page');
Route::post('/sales/store', [SalesController::class, 'store'])->middleware(['auth', 'verified'])->name('sales.store');
Route::post('/sales/destroy/{id}', [SalesController::class, 'destroy'])->middleware(['auth', 'verified'])->name('sales.destroy');
Route::get('/sales/download', [SalesController::class, 'downloadCsv'])->name('sales.download');
Route::get('/sales/year/download', [SalesController::class, 'downloadYearCsv'])->name('sales.year.download');

## Purchase
Route::get('/purchase/page', [PurchaseController::class, 'index'])->middleware(['auth', 'verified'])->name('purchase.page');
Route::post('/purchase/store', [PurchaseController::class, 'store'])->middleware(['auth', 'verified'])->name('purchase.store');
Route::post('/purchase/destroy/{id}', [PurchaseController::class, 'destroy'])->middleware(['auth', 'verified'])->name('purchase.destroy');
Route::get('/purchases/download', [PurchaseController::class, 'downloadCsv'])->name('purchase.download');
