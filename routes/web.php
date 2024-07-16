<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;


Route::controller(UserController::class)->group( function () {
    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::post('/register', [UserController::class, 'register'])->name('register');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});

Route::get('/movies', function () {
    return view('ajax');
})->name('movies');

Route::resource('/movie', MovieController::class);
