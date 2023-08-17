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
Route::prefix('groups')->group(function () {
    Route::get('/', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/store', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/edit/{id}', [GroupController::class, 'edit'])->name('groups.edit');
    Route::put('/update/{id}', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/destroy/{id}', [GroupController::class, 'destroy'])->name('groups.destroy');
    Route::get('/search', [GroupController::class, 'search'])->name('groups.search');
    Route::get('/show/{id}', [GroupController::class, 'show'])->name('groups.show');
    Route::put('/saveRoles/{id}', [GroupController::class, 'saveRoles'])->name('groups.saveRoles');
});
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/show{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/export', [UserController::class, 'export'])->name('users.export');
    Route::get('/trash', [UserController::class, 'trash'])->name('users.trash');
    Route::get('/restore/{id}', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/force_destroy/{id}', [UserController::class, 'force_destroy'])->name('users.force_destroy');
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
