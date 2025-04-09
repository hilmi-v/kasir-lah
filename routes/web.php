<?php

use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/', Welcome::class)->name('home');

    // categories
    Route::get('/categories', App\Livewire\Category\Index::class)->name('categories.index');
    Route::get('/categories/create', App\Livewire\Category\Create::class)->name('categories.create');
    Route::get('/categories/edit/{id}', App\Livewire\Category\Edit::class)->name('categories.edit');

    // products
    Route::get('/products', App\Livewire\Product\Index::class)->name('products.index');
    Route::get('/products/create', App\Livewire\Product\Create::class)->name('products.create');
    Route::get('/products/edit/{id}', App\Livewire\Product\Edit::class)->name('products.edit');

    //stock
    Route::get('/stock', App\Livewire\Stock\Index::class)->name('stock.index');
    Route::get('/stock/log', App\Livewire\Stock\Log::class)->name('stock.log');

    //transaction
    // products
    Route::get('/transactions', App\Livewire\Transaction\Index::class)->name('transactions.index');
    Route::get('/transactions/create', App\Livewire\Transaction\Create::class)->name('transactions.create');
    Route::get('/transactions/detail/{id}', App\Livewire\Transaction\Detail::class)->name('transactions.detail');

    Route::get('/report', App\Livewire\Report::class)->name('report');

    Route::get('/profile', App\Livewire\Profile::class)->name('profile');
});

Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/login', App\Livewire\Login::class)->middleware('guest')->name('login');
Route::get('/forgot-password', App\Livewire\Auth\ForgotPassword::class)->name('forgot.password');
Route::get('/reset-password/{token}', App\Livewire\Auth\ResetPassword::class)->name('password.reset');

