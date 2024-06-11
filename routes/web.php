<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

    Route::group(['prefix' => 'auth'], function () {
        Route::group(['middleware' => 'guest'], function () {
        Route::get('signup', [\App\Http\Controllers\Web\AuthController::class, 'signUp'])->name('signup');
        Route::post('register', [\App\Http\Controllers\Web\AuthController::class, 'register'])->name('register');
        Route::get('signin', [\App\Http\Controllers\Web\AuthController::class, 'signIn'])->name('signin');
        Route::post('login', [\App\Http\Controllers\Web\AuthController::class, 'login'])->name('login');
        });

        Route::post('logout', [\App\Http\Controllers\Web\AuthController::class, 'logout'])->middleware('auth')->name('logout');
    });
