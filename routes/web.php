<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
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
