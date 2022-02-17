<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
|
| These routes can be viewed without authentication.
|
*/

// Authentication routes
Route::get('login', [LoginController::class, 'index'])->name('login');

// Authentication providers and callbacks
Route::get('auth/google', [LoginController::class, 'redirect'])->name('auth.google');
Route::get('auth/google/callback', [LoginController::class, 'callback'])->name('auth.google.callback');


/*
|--------------------------------------------------------------------------
| Private
|--------------------------------------------------------------------------
|
| These routes can only be viewed after authentication.
|
*/

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', static fn () => view('home.index'));
});
