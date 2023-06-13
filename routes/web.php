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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->middleware('can:admin')->group(function () {
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
});
