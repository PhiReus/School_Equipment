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
<<<<<<< HEAD
Route::resource('devices',\App\Http\Controllers\DeviceController::class);
=======
Route::resource('groups',\App\Http\Controllers\GroupController::class);
>>>>>>> d4bcefefcc9cfda8785ce3308fe9e215aa10e321
