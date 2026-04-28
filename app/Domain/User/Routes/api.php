<?php

use Illuminate\Support\Facades\Route;
use App\Domain\User\Http\Controllers\Admin\UserController;

Route::middleware(['api', 'auth:sanctum'])->group(function () {

    // Admin Routes
    Route::prefix('api/v1/admin/users')
        ->name('api.v1.admin.users.')
        ->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{id}', [UserController::class, 'show'])->name('show');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });
});
