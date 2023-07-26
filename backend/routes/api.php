<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
    Route::apiResources([
        'users' => UserController::class,
        'categories' => CategoryController::class,
        'products' => ProductController::class,
    ]);
});

Route::post('/v1/users/login', [UserController::class, 'login']);
Route::post('/v1/users/login-check', [UserController::class, 'check']);
