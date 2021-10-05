<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Api\AuthController;


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
// public routes
Route::post('register', [AuthController::class, 'register'])->name('register'); //For register
Route::post('login', [AuthController::class, 'login'])->name('login'); //For register

// for social media regieteration and login
Route::get('social-login/google', [AuthController::class, 'redirectToGoogle'])->name('social-login'); //pass type=company or user
Route::get('social-login/google/callback', [AuthController::class, 'handleGoogleCallback']);

// protected routes
Route::group(['middleware'=>['auth:sanctum']],function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
