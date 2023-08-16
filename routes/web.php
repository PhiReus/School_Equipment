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
    return view('layouts/master');
});


// Room
Route::prefix('rooms')->group(function () {
    Route::get('/search', [\App\Http\Controllers\RoomController::class, 'search'])->name('rooms.search');
    Route::get('/trash', [\App\Http\Controllers\RoomController::class, 'trash'])->name('rooms.trash');
    Route::get('/restore/{id}', [\App\Http\Controllers\RoomController::class, 'restore'])->name('rooms.restore');
    Route::delete('/force_destroy/{id}', [\App\Http\Controllers\RoomController::class, 'force_destroy'])->name('rooms.force_destroy');
});
Route::resource('rooms',\App\Http\Controllers\RoomController::class);


// Group
Route::resource('groups',\App\Http\Controllers\GroupController::class);
