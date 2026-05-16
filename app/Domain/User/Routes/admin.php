<?php

use Illuminate\Support\Facades\Route;
use App\Domain\User\Http\Controllers\Admin\Web\UserWebController;

Route::prefix('admin')->name('admin.')->middleware(['web', 'auth'])->group(function () {
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/',            [UserWebController::class, 'index'])->name('index');
        Route::get('/create',      [UserWebController::class, 'create'])->name('create');
        Route::post('/',           [UserWebController::class, 'store'])->name('store');
        Route::get('/{id}/edit',   [UserWebController::class, 'edit'])->name('edit');
        Route::put('/{id}',        [UserWebController::class, 'update'])->name('update');
        Route::delete('/{id}',     [UserWebController::class, 'destroy'])->name('destroy');
    });
});
