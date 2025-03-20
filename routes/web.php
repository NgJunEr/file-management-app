<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PrController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.login.login');
});

Route::get('/registration', function () {
    return view('pages.login.register');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Supplier routes
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
    Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    // Customer routes
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update'); // Add this line
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    
    // Purchase Requisition (PR) routes
    Route::get('/prs', [PrController::class, 'index'])->name('prs.index');
    Route::post('/prs', [PrController::class, 'store'])->name('prs.store');
    Route::get('/prs/{pr}', [PrController::class, 'show'])->name('prs.show');
    Route::get('/prs/{pr}/edit', [PrController::class, 'edit'])->name('prs.edit');
    Route::put('/prs/{pr}', [PrController::class, 'update'])->name('prs.update');
    Route::delete('/prs/{pr}', [PrController::class, 'destroy'])->name('prs.destroy');

    Route::post('/prs/export-sql', [PrController::class, 'exportSQL'])->name('prs.export-sql');

});

require __DIR__.'/auth.php';
