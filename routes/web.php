<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\ArusKasController;
use App\Http\Controllers\BukuBesarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\LabaRugiController;
use App\Http\Controllers\NeracaController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('assets/{folder}/{filename}', function ($folder,$filename){
    $path = storage_path('app/' . $folder . '/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

Route::get('/', [HomeController::class, 'index'])->name('/');

Route::prefix('akun')->group(function () {
    Route::get('/', [AkunController::class, 'index'])->name('akun');
    Route::post('search', [AkunController::class, 'search'])->name('akun.search');
    Route::post('info', [AkunController::class, 'info'])->name('akun.info');
    Route::post('save', [AkunController::class, 'save'])->name('akun.save');
    Route::post('delete', [AkunController::class, 'delete'])->name('akun.delete');
    Route::post('reposisi', [AkunController::class, 'reposisi'])->name('akun.reposisi');
});

Route::prefix('transaksi')->group(function () {
    Route::get('/', [TransaksiController::class, 'index'])->name('transaksi');
    Route::post('search', [TransaksiController::class, 'search'])->name('transaksi.search');
    Route::post('info', [TransaksiController::class, 'info'])->name('transaksi.info');
    Route::post('save', [TransaksiController::class, 'save'])->name('transaksi.save');
    Route::post('delete', [TransaksiController::class, 'delete'])->name('transaksi.delete');

    Route::post('search_detail', [TransaksiController::class, 'search_detail'])->name('transaksi.search_detail');
    Route::post('save_detail', [TransaksiController::class, 'save_detail'])->name('transaksi.save_detail');
    Route::post('delete_detail', [TransaksiController::class, 'delete_detail'])->name('transaksi.delete_detail');
});

Route::prefix('jurnal')->group(function () {
    Route::get('/', [JurnalController::class, 'index'])->name('jurnal');
    Route::get('cetak', [JurnalController::class, 'cetak'])->name('jurnal.cetak');
    Route::post('search', [JurnalController::class, 'search'])->name('jurnal.search');
});

Route::prefix('buku_besar')->group(function () {
    Route::get('/', [BukuBesarController::class, 'index'])->name('buku_besar');
    Route::get('cetak', [BukuBesarController::class, 'cetak'])->name('buku_besar.cetak');
    Route::post('search', [BukuBesarController::class, 'search'])->name('buku_besar.search');
});

Route::prefix('arus_kas')->group(function () {
    Route::get('/', [ArusKasController::class, 'index'])->name('arus_kas');
    Route::get('cetak', [ArusKasController::class, 'cetak'])->name('arus_kas.cetak');
    Route::post('search', [ArusKasController::class, 'search'])->name('arus_kas.search');
});

Route::prefix('laba_rugi')->group(function () {
    Route::get('/', [LabaRugiController::class, 'index'])->name('laba_rugi');
    Route::get('cetak', [LabaRugiController::class, 'cetak'])->name('laba_rugi.cetak');
    Route::post('search', [LabaRugiController::class, 'search'])->name('laba_rugi.search');
});

Route::prefix('neraca')->group(function () {
    Route::get('/', [NeracaController::class, 'index'])->name('neraca');
    Route::get('cetak', [NeracaController::class, 'cetak'])->name('neraca.cetak');
    Route::post('search', [NeracaController::class, 'search'])->name('neraca.search');
});
