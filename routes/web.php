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

//Device
Route::prefix('devices')->group(function () {
    Route::get('/trash', [\App\Http\Controllers\DeviceController::class, 'trash'])->name('devices.trash');
    Route::get('/restore/{id}', [\App\Http\Controllers\DeviceController::class, 'restore'])->name('devices.restore');
    Route::delete('/force_destroy/{id}', [\App\Http\Controllers\DeviceController::class, 'force_destroy'])->name('devices.forceDelete');
});
Route::resource('devices',\App\Http\Controllers\DeviceController::class);

// Room
Route::prefix('rooms')->group(function () {
    Route::get('/trash', [\App\Http\Controllers\RoomController::class, 'trash'])->name('rooms.trash');
    Route::get('/restore/{id}', [\App\Http\Controllers\RoomController::class, 'restore'])->name('rooms.restore');
    Route::delete('/force_destroy/{id}', [\App\Http\Controllers\RoomController::class, 'force_destroy'])->name('rooms.force_destroy');
});
Route::resource('rooms',\App\Http\Controllers\RoomController::class);

// Group
Route::resource('groups',\App\Http\Controllers\GroupController::class);

// Borrow_devices

Route::prefix('borrow_devices')->group(function () {
    Route::get('/trash', [\App\Http\Controllers\BorrowDevicesController::class, 'trash'])->name('borrow_devices.trash');
    Route::get('/restore/{id}', [\App\Http\Controllers\BorrowDevicesController::class, 'restore'])->name('borrow_devices.restore');
    Route::delete('/force_destroy/{id}', [\App\Http\Controllers\BorrowDevicesController::class, 'force_destroy'])->name('borrow_devices.force_destroy');
});
Route::resource('borrow_devices',\App\Http\Controllers\BorrowDevicesController::class);
