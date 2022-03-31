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
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login'])->middleware('gateway');

Route::get('email/verify/{id}', [App\Http\Controllers\Api\AuthController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [App\Http\Controllers\Api\AuthController::class, 'resend'])->name('verification.resend');

Route::group(['middleware' => ['auth:sanctum','isAdmin']], function(){

    Route::apiResource('/book', App\Http\Controllers\Api\BookController::class);
    Route::apiResource('/author', App\Http\Controllers\Api\AuthorController::class);
  
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
});

Route::get('/public/post', [App\Http\Controllers\Api\FetchController::class, 'getData']);
Route::get('/public/post/{id}', [App\Http\Controllers\Api\FetchController::class, 'showData']);
Route::post('/public/post', [App\Http\Controllers\Api\FetchController::class, 'createData']);
Route::put('/public/post/{id}', [App\Http\Controllers\Api\FetchController::class, 'updateData']);
Route::patch('/public/post/{id}', [App\Http\Controllers\Api\FetchController::class, 'patchData']);
Route::delete('/public/post/{id}', [App\Http\Controllers\Api\FetchController::class, 'deleteData']);
Route::get('/public/post?userId={id}', [App\Http\Controllers\Api\FetchController::class, 'filteringData']);
Route::get('/public/post/{id}/comments', [App\Http\Controllers\Api\FetchController::class, 'nestedData']);
Route::get('/public/users/{id}/todos', [App\Http\Controllers\Api\FetchController::class, 'userTodos']);
