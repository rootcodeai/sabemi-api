<?php

use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/admin/auth.php';

Route::prefix('admin')->name('admin.')->middleware(['web', 'auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
