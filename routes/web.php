<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Auth;
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

    if (Auth::user()->role == 'superadmin') {
        return view('client.report-page.report-page');
    } else {
        return view('client.dashboard.dashboard');
    }

})->middleware(['auth', 'verified', 'check.status'])->name('dashboard');

// Route::get('/sales', function () {
//     return view('client.sales-page.sales-page');
// })->middleware(['auth', 'verified'])->name('sales.page');

## Settings
Route::get('/settings/page', [SettingController::class, 'index'])->middleware(['auth', 'check.status', 'verified'])->name('settings.page');
Route::post('/settings/store', [SettingController::class, 'store'])->middleware(['auth', 'check.status', 'verified'])->name('settings.store');

Route::get('/settings/edit/page/{id}', [SettingController::class, 'edit'])->middleware(['auth', 'check.status', 'verified'])->name('settings.edit');
Route::post('/settings/update/page/{id}', [SettingController::class, 'update'])->middleware(['auth', 'check.status', 'verified'])->name('settings.edit.page');
Route::get('/settings/status/{id}', [SettingController::class, 'status'])->middleware(['auth', 'check.status', 'verified'])->name('settings.status');
Route::post('/settings/destroy/{id}', [SettingController::class, 'destroy'])->middleware(['auth', 'check.status', 'verified'])->name('settings.destroy');
Route::post('/settings/change/password/{id}', [SettingController::class, 'changePassword'])->middleware(['auth', 'check.status', 'verified'])->name('settings.change.password');
// Route::get('/settings/download', [SalesController::class, 'downloadCsv'])->name('settings.download');


## Sales
Route::get('/sales/page', [SalesController::class, 'index'])->middleware(['auth', 'check.status', 'verified'])->name('sales.page');
Route::post('/sales/store', [SalesController::class, 'store'])->middleware(['auth', 'check.status', 'verified'])->name('sales.store');
Route::post('/sales/destroy/{id}', [SalesController::class, 'destroy'])->middleware(['auth', 'check.status', 'verified'])->name('sales.destroy');
Route::get('/sales/download', [SalesController::class, 'downloadCsv'])->name('sales.download');
Route::get('/sales/report/download', [SalesController::class, 'downloadReportCsv'])->name('sales.report.download');
// Route::get('/sales/year/download', [SalesController::class, 'downloadYearCsv'])->name('sales.year.download');
Route::get('/sales/year/download', [SalesController::class, 'exportYearlyReport'])->name('sales.year.download');
Route::post('/sales/month/view', [SalesController::class, 'salesMonthView'])->name('sales.month.view');
Route::post('/sales/year/view', [SalesController::class, 'salesYearView'])->name('sales.year.view');

## Purchase
Route::get('/purchase/page', [PurchaseController::class, 'index'])->middleware(['auth', 'check.status', 'verified'])->name('purchase.page');
Route::post('/purchase/store', [PurchaseController::class, 'store'])->middleware(['auth', 'check.status', 'verified'])->name('purchase.store');
Route::post('/purchase/destroy/{id}', [PurchaseController::class, 'destroy'])->middleware(['auth', 'check.status', 'verified'])->name('purchase.destroy');
Route::get('/purchases/download', [PurchaseController::class, 'downloadCsv'])->name('purchase.download');

Route::post('/purchases/month/view', [PurchaseController::class, 'purchaseMonthView'])->name('purchases.month.view');
Route::post('/purchases/year/view', [PurchaseController::class, 'purchaseYearView'])->name('purchases.year.view');
Route::get('/purchases/report/download', [PurchaseController::class, 'exportYearlyReport'])->name('purchases.report.download');
Route::get('/purchases/report', [PurchaseController::class, 'downloadReportCsv'])->name('purchase.report.download');

Route::get('/purchase/details/{id}', [PurchaseController::class, 'view'])->middleware(['auth', 'check.status', 'verified'])->name('purchase.details.page');

## Report
Route::get('/report/page', [ReportController::class, 'index'])->middleware(['auth', 'check.status', 'verified'])->name('report.page');
Route::get('/sale/report/page', [ReportController::class, 'saleReport'])->middleware(['auth', 'check.status', 'verified'])->name('sale.report.page');
Route::get('/purchase/report/page', [ReportController::class, 'puchaseReport'])->middleware(['auth', 'check.status', 'verified'])->name('purchase.report.page');
