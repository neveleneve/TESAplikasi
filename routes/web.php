<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes([
    'register' => false,
    'reset' => false,
]);

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('dashboard');

Route::resource('daftar-barang', App\Http\Controllers\ItemController::class);
Route::resource('transaksi', App\Http\Controllers\TransaksiController::class);
Route::get('peramalan', [App\Http\Controllers\PeramalanController::class, 'index'])
    ->name('peramalan.index');

// report semua item yang tersedia ketika dicetak
Route::get('laporan/item', [App\Http\Controllers\LaporanController::class, 'item'])
    ->name('laporan.item');
// report semua transaksi dengan rentang waktu
Route::post('laporan/transaksi', [App\Http\Controllers\LaporanController::class, 'transaksiAll'])
    ->name('laporan.transaksi.all');
// report per transaksi
Route::get('laporan/transaksi/{transaksi}', [App\Http\Controllers\LaporanController::class, 'transaksiOne'])
->name('laporan.transaksi.one');
// report ramalan menggunakan forecasting
Route::get('laporan/forecasting', [App\Http\Controllers\LaporanController::class, 'forecasting'])
    ->name('laporan.forecasting');
