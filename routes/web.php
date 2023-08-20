<?php
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('layouts/master');
// });

//Group
Route::prefix('groups')->group(function () {
    Route::get('/show/{id}', [GroupController::class, 'show'])->name('groups.show');
    Route::put('/saveRoles/{id}', [GroupController::class, 'saveRoles'])->name('groups.saveRoles');
});
Route::resource('groups',\App\Http\Controllers\GroupController::class);


//User
Route::prefix('users')->group(function () {
    Route::get('/export', [UserController::class, 'export'])->name('users.export');
    Route::get('/trash', [UserController::class, 'trash'])->name('users.trash');
    Route::get('/restore/{id}', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/force_destroy/{id}', [UserController::class, 'force_destroy'])->name('users.force_destroy');
});
Route::resource('users',\App\Http\Controllers\UserController::class);


//Device
Route::prefix('devices')->group(function () {
    Route::get('/trash', [\App\Http\Controllers\DeviceController::class, 'trash'])->name('devices.trash');
    Route::get('/restore/{id}', [\App\Http\Controllers\DeviceController::class, 'restore'])->name('devices.restore');
    Route::delete('/force_destroy/{id}', [\App\Http\Controllers\DeviceController::class, 'forceDelete'])->name('devices.forceDelete');
});
Route::resource('devices',\App\Http\Controllers\DeviceController::class);

// Room
Route::prefix('rooms')->group(function () {
    Route::get('/trash', [\App\Http\Controllers\RoomController::class, 'trash'])->name('rooms.trash');
    Route::get('/restore/{id}', [\App\Http\Controllers\RoomController::class, 'restore'])->name('rooms.restore');
    Route::delete('/force_destroy/{id}', [\App\Http\Controllers\RoomController::class, 'force_destroy'])->name('rooms.force_destroy');
});
Route::resource('rooms',\App\Http\Controllers\RoomController::class);


// Borrow 
Route::prefix('borrows')->group(function () {
    Route::get('/trash', [\App\Http\Controllers\BorrowController::class, 'trash'])->name('borrows.trash');
    Route::get('/restore/{id}', [\App\Http\Controllers\BorrowController::class, 'restore'])->name('borrows.restore');
    Route::delete('/force_destroy/{id}', [\App\Http\Controllers\BorrowController::class, 'forceDelete'])->name('borrows.forceDelete');
    Route::get('/devices', [\App\Http\Controllers\BorrowController::class, 'devices'])->name('borrows.devices');
});
Route::resource('borrows',\App\Http\Controllers\BorrowController::class);

