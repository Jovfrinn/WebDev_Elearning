<?php

use App\Http\Controllers\API\frontend\MateriController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialUsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SubMateriController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MaterialController::class, 'index'])->name('get.index');
Route::get('/join/{id}', [MaterialController::class, 'show'])->name('join.class');

Route::get('materi/{id}', [SubMateriController::class, 'index'])->name('sub.materi');
Route::get('materi/detail/{id}', [SubMateriController::class, 'show'])->name('show.materi');

Route::get('materi/join/{id}', [MaterialUsersController::class, 'index'])->name('materi.join');

// Route Quiz
Route::get('quiz/start/{id}', [QuizController::class, 'startQuiz'])->name('go.quiz');
Route::get('/quiz/{id}', [QuizController::class, 'show'])->name('quiz.show');
Route::post('/quiz/{id}/answer', [QuizController::class, 'storeAnswer'])->name('quiz.store');
Route::get('/result', [QuizController::class, 'index'])->name('quiz.result');
Route::get('/result/{id}', [QuizController::class, 'resultQuiz'])->name('quiz.results');
Route::get('/quiz/previous/{id}', [QuizController::class, 'previousQuestion'])->name('quiz.previous');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';

