<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MedicimeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('home');
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::prefix('admin')->name('admin.')->middleware('can:pemilik')->group(function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])
                ->name('index');
        });
    });
    
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])
            ->name('index');
    });
    
    Route::prefix('brands')->name('brands.')->group(function () {
        Route::get('/', [BrandController::class, 'index'])
            ->name('index');
    });
    
    Route::prefix('suppliers')->name('suppliers.')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])
            ->name('index');
    });
    
    Route::prefix('medicines')->name('medicines.')->group(function () {
        Route::get('/', [MedicimeController::class, 'index'])
            ->name('index');
    });
    
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])
            ->name('index');
    
        Route::get('/request', [OrderController::class, 'request'])
            ->name('request');

        Route::get('/print/{id}', [OrderController::class, 'print'])
            ->name('print');
    });
    
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::get('/', [OrderController::class, 'sales'])
            ->name('index');
    
        Route::get('/sell', [OrderController::class, 'sell'])
            ->name('sell');

        Route::get('/print/{id}', [OrderController::class, 'printSaleInfo'])
            ->name('print');
    });
    
    Route::prefix('history')->name('histories.')->group(function () {
        Route::get('/pembelian', [OrderController::class, 'purchasesHistory'])
            ->name('purchases');
    
        Route::get('/penjualan', [OrderController::class, 'salesHistory'])
            ->name('sales');

        Route::get('/barang', [StockController::class, 'stockHistory'])
            ->name('sales');

        Route::get('/print/purchases/{date}', [OrderController::class, 'printPurchases'])
            ->name('printPurchases');

        Route::get('/print/sales/{date}', [OrderController::class, 'printSales'])
            ->name('printSales');
    });
    
    Route::prefix('stock')->name('stocks.')->group(function () {
        Route::get('/', [StockController::class, 'index'])
            ->name('index');

        Route::get('/expiry', [StockController::class, 'expiry'])
            ->name('expiry');
    });
});
