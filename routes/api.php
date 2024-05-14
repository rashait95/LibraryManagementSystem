<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ReviewController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//authetication routes
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->middleware('auth:api');

});


//Author routes
Route::middleware(['isAdmin'])->group(function () {
    Route::post('addauthor',[AuthorController::class, 'store']);
    Route::delete('deleteauthor/{id}',[AuthorController::class, 'destroy']);
    Route::put('updateauthor/{id}',[AuthorController::class, 'update']);
});

Route::get('authors',[AuthorController::class,'index']);
Route::get('authors/{id}',[AuthorController::class,'show']);
 
//User Profile Request

Route::get('users/{user}', [UserController::class, 'showprofile'])->middleware('api');
Route::put('users/update/{user}', [UserController::class, 'updateprofile'])->middleware('api');

//Book routes

Route::middleware(['isAdmin'])->group(function () {
    Route::post('addbook',[BookController::class,'store']);
    Route::delete('deletebook/{id}',[BookController::class,'destroy']);
    Route::put('updatebook/{id}',[BookController::class,'update']);
});

Route::get('books',[BookController::class,'index']);
Route::get('books/{id}',[BookController::class,'show']);


//Review routes
Route::get('reviews',[ReviewController::class,'index']);
Route::get('reviews/{id}',[ReviewController::class,'show']);

Route::middleware(['isAdmin'])->group(function () {
    Route::post('addbookreview',[ReviewController::class,'store_book_review']);
    Route::post('addauthorreview',[ReviewController::class,'store_author_review']);
    Route::delete('deletereview/{id}',[ReviewController::class,'destroy']);
    Route::put('updatereview/{id}',[ReviewController::class,'update']);
});