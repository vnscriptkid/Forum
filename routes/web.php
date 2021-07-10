<?php

use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\ThreadRepliesController;
use App\Http\Controllers\ThreadsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::post('/threads', [ThreadsController::class, 'store']);
    Route::delete('/threads/{channel:slug}/{thread}', [ThreadsController::class, 'destroy']);
    Route::post('/threads/{channel}/{thread}/replies', [ThreadRepliesController::class, 'store']);
    Route::get('/threads/create', [ThreadsController::class, 'create']);
    Route::post('/replies/{reply}/favorites', [FavoritesController::class, 'store']);
    Route::delete('/replies/{reply}', [ThreadRepliesController::class, 'destroy']);
});

Route::get('/threads/{channel:slug}', [ThreadsController::class, 'index']);
Route::get('/threads/{channelId}/{thread}', [ThreadsController::class, 'show']);
Route::get('/threads', [ThreadsController::class, 'index']);

Route::get('/profiles/{user}', [ProfilesController::class, 'show'])->name('profile');

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
