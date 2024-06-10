<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(
    [
        'prefix' => 'v1',
        //'middleware'=>'auth:sanctum'
    ],
    function ($router) {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
            Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
            Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');
        });


        Route::group(['prefix' => 'profile' , 'middleware' => 'auth:sanctum'], function () {
            Route::post('update', [\App\Http\Controllers\Api\UserController::class, 'update']);
            // Route::put('update', [\App\Http\Controllers\Api\UserController::class, 'update']);

        });

    },);
