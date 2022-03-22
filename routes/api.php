<?php

use Illuminate\Http\Request;
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
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::get('email/verify/{id}', [App\Http\Controllers\Api\AuthController::class, 'verify'])->name('verification.verify');
Route::get('email/resend', [App\Http\Controllers\Api\AuthController::class, 'resend'])->name('verification.resend');


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function() {
        return auth()->user();
    });

    Route::apiResource('/book', App\Http\Controllers\Api\BookController::class);
    Route::apiResource('/author', App\Http\Controllers\Api\AuthorController::class);

    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});