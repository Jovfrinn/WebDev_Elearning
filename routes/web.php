<?php

use App\Http\Controllers\API\frontend\MateriController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialUsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubMateriController;
use Illuminate\Support\Facades\Route;

// Route::get('/', [MaterialController::class, 'index'])->name('get.index');
Route::get('/join/{id}', [MaterialController::class, 'show'])->name('join.class');

Route::get('materi/{id}', [SubMateriController::class, 'index'])->name('sub.materi');
Route::get('materi/detail/{id}', [SubMateriController::class, 'show'])->name('show.materi');

Route::get('materi/join/{id}', [MaterialUsersController::class, 'index'])->name('materi.join');



Route::get('/', [MateriController::class, 'index'])->name('get.index');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';

