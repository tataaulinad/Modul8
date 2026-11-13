
<?php

use Illuminate\Support\Facades\Route;
use Modules\Buku\Http\Controllers\BukuController;

// Admin dan User dapat melihat daftar buku
Route::middleware(['auth', 'role:admin,user'])->group(function () {
    Route::get('buku', [BukuController::class, 'index'])
        ->name('buku.index');
});

// Hanya Admin yang dapat mengelola buku
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('buku/create', [BukuController::class, 'create'])
        ->name('buku.create');

    Route::post('buku', [BukuController::class, 'store'])
        ->name('buku.store');

    Route::get('buku/{buku}/edit', [BukuController::class, 'edit'])
        ->name('buku.edit');

    Route::put('buku/{buku}', [BukuController::class, 'update'])
        ->name('buku.update');

    Route::delete('buku/{buku}', [BukuController::class, 'destroy'])
        ->name('buku.destroy');
});
