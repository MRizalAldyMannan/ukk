<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Livewire\Beranda;
use App\Livewire\User;
use App\Livewire\Transaksi;
use App\Livewire\Produk;
use App\Livewire\Laporan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', Beranda::class)->name('home');
    Route::get('/user', User::class)->name('user');
    Route::get('/transaksi', Transaksi::class)->name('transaksi');
    Route::get('/produk', Produk::class)->name('produk');
    Route::get('/laporan', Laporan::class)->name('laporan');
});
