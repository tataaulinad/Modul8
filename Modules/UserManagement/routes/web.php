<?php

use Illuminate\Support\Facades\Route;
use Modules\UserManagement\Http\Controllers\UserManagementController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin/users')
    ->name('admin.users.')
    ->group(function () {

        Route::get('/', [UserManagementController::class, 'index'])
            ->name('index');

        Route::post('/', [UserManagementController::class, 'store'])
            ->name('store');

        Route::put('/{user}', [UserManagementController::class, 'update'])
            ->name('update');

        Route::delete('/{user}', [UserManagementController::class, 'destroy'])
            ->name('destroy');
    });
