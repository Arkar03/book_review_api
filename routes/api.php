<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
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

// Route::get('data', [UserController::class,'getData'])->name('data');


Route::group(['prefix' => 'user'], function () {
    Route::post('/store', [UserController::class, 'store']);    //to store new books into db
});


Route::group(['prefix' => 'book'], function () {
    Route::get('/{id?}', [BookController::class, 'index']);     //to retrieve all or specific book
    Route::get('{id}/detail', [BookController::class, 'getDetails']);     //to retrieve details for a specific book
    Route::post('/store', [BookController::class, 'store']);    //to store new books into db
    Route::put('/update/{id}', [BookController::class, 'update']);    //to update books
    Route::delete('/delete/{id}', [BookController::class, 'delete']);    //to delete books

    Route::post('{id}/rating', [ActionController::class, 'rate']);  //creating rating
    Route::post('{id}/review', [ActionController::class, 'review']);    //creating review
    Route::post('review/rate', [ActionController::class, 'rateAndReview']);
});

Route::any('{any}', function () {
    return response()->json(['error' => 'Route Not Found'], 404);
})->where('any', '.*');
