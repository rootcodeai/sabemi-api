<?php

use Illuminate\Support\Facades\Route;
use App\Domain\User\Http\Controllers\Admin\Web\UserWebController;

Route::prefix('admin')->name('admin.')->middleware(['web', 'auth'])->group(function () {
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserWebController::class, 'index'])->name('index');
    });
});
