<?php

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

Route::get('login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::post('authenticate', [App\Http\Controllers\AuthController::class, 'authenticate'])->name('authenticate');
Route::get('register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('register', [App\Http\Controllers\AuthController::class, 'do_register'])->name('do_register');

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
    Route::get('transaction-list', [App\Http\Controllers\HomeController::class, 'transaction_list'])->name('transaction_list');
    Route::get('add-transaction', [App\Http\Controllers\HomeController::class, 'add_transaction'])->name('add_transaction');
    Route::post('save-transaction', [App\Http\Controllers\HomeController::class, 'save_transaction'])->name('save_transaction');
});