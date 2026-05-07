<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::get('/welcome', function () {
    return view('welcome');
});
