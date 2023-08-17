<?php
use App\Http\Controllers\DeviceController;
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
Route::get('/devices/trash', [DeviceController::class, 'trash'])->name('devices.trash');
Route::get('/restore/{id}', [DeviceController::class, 'restore'])->name('devices.restore');
Route::delete('/forceDelete/{id}', [DeviceController::class, 'forceDelete'])->name('devices.forceDelete');
Route::get('/search', [DeviceController::class, 'search'])->name('devices.search');
Route::resource('devices',\App\Http\Controllers\DeviceController::class);

Route::resource('groups',\App\Http\Controllers\GroupController::class);
