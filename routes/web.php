<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/admin/products', ProductController::class)->names([
        'index'   => 'products.index',
        'create'  => 'products.create',
        'store'   => 'products.store',
        'show'    => 'products.show',
        'edit'    => 'products.edit',
        'update'  => 'products.update',
        'destroy' => 'products.destroy',
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/products', [UserProductController::class, 'index'])->name('user.products.index');

    Route::post('/cart/add/{id}',      [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear',         [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/invoices',                [InvoiceController::class, 'index'])->name('user.invoices.index');
    Route::get('/invoices/create',         [InvoiceController::class, 'create'])->name('user.invoices.create');
    Route::post('/invoices',               [InvoiceController::class, 'store'])->name('user.invoices.store');
    Route::get('/invoices/{id}',           [InvoiceController::class, 'show'])->name('user.invoices.show');
    Route::get('/invoices/{id}/print',     [InvoiceController::class, 'print'])->name('user.invoices.print');

    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
