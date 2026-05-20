<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\API\frontend\MateriController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialUsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SubMateriController;
use App\Http\Controllers\Teacher\QuizController as TeacherQuizController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\UpdateProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::get('/home', [MaterialController::class, 'index'])->name('get.index');
Route::get('/all/materi', [MaterialController::class, 'allMateri'])->name('all.materi');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [UpdateProfileController::class, 'index'])->name('profile');
    Route::put('/profile/{id}', [UpdateProfileController::class, 'update'])->name('profile.update');



Route::get('/join/{id}', [MaterialController::class, 'show'])->name('join.class');
Route::get('materi/{id}', [SubMateriController::class, 'index'])->name('sub.materi');
Route::get('materi/detail/{id}', [SubMateriController::class, 'show'])->name('show.materi');



// Route Quiz
Route::get('quiz/start/{id}', [QuizController::class, 'startQuiz'])->name('go.quiz');
Route::get('/quiz/{id}', [QuizController::class, 'show'])->name('quiz.show');
Route::post('/quiz/{id}/answer', [QuizController::class, 'storeAnswer'])->name('quiz.store');
Route::get('/result', [QuizController::class, 'index'])->name('quiz.result');
Route::get('/result/{id}', [QuizController::class, 'resultQuiz'])->name('quiz.results');
Route::get('/quiz/previous/{id}', [QuizController::class, 'previousQuestion'])->name('quiz.previous');

// Student-only: progress + activity logging (role 1)
Route::middleware('cekRole:1')->group(function () {
    Route::get('/progress', [App\Http\Controllers\ProgressController::class, 'index'])->name('progress.index');
    Route::get('/progress/{id}', [App\Http\Controllers\ProgressController::class, 'show'])->name('progress.show');
    Route::post('/learning-log/start', [App\Http\Controllers\LearningLogController::class, 'start'])->name('log.start');
    Route::post('/learning-log/end', [App\Http\Controllers\LearningLogController::class, 'end'])->name('log.end');
});
});

// admin
Route::middleware(['auth','cekRole:3'])->group(function(){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::get('/admin/student', [AdminController::class, 'student'])->name('get.student');
    Route::get('/admin/teacher', [AdminController::class, 'teacher'])->name('get.teachers');
    Route::get('/admin/materi', [AdminController::class, 'materi'])->name('get.materi');


    // verify teacher
    Route::get('/admin/verifikasi/teacher', [AdminController::class, 'getTeacher'])->name('get.teacher');
    Route::get('/admin/verifikasi/teacher/{id}', [AdminController::class, 'verifikasi'])->name('verifikasi.teacher');
    Route::get('/admin/delete/teacher/{id}', [AdminController::class, 'deleteTeacher'])->name('delete.teacher');

    // create teacher account
    Route::get('/admin/teacher/create', [AdminController::class, 'createTeacher'])->name('create.teacher');
    Route::post('/admin/teacher/store', [AdminController::class, 'storeTeacher'])->name('store.teacher');
});

// Teacher
Route::middleware(['auth','cekRole:2'])->group(function(){
    Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher.home');
    Route::get('/teacher/add/materi', [TeacherController::class, 'create'])->name('add.materi');
    Route::post('/teacher/add/materi', [TeacherController::class, 'store'])->name('store.materi');
    Route::get('/teacher/submateri/{id}', [TeacherController::class, 'indexSubMateri'])->name('get.subMateri');
    Route::get('/teacher/add/submateri/{id}', [TeacherController::class, 'createSubMateri'])->name('add.subMateri');
    Route::post('/teacher/add/submateri', [TeacherController::class, 'storeSubMateri'])->name('store.subMateri');
    Route::get('/teacher/delete/submateri/{id}', [TeacherController::class, 'destroySubMateri'])->name('delete.subMateri');
    
    Route::get('/teacher/join/materi/{id}', [TeacherController::class, 'showJoin'])->name('show.join');
    Route::post('/teacher/upload/video', [TeacherController::class, 'storeVideo'])->name('store.video');
    
    // quiz
    Route::get('/teacher/add/quiz/{id}', [TeacherQuizController::class, 'index'])->name('add.quiz');
    Route::post('/teacher/add/quiz', [TeacherQuizController::class, 'store'])->name('store.quiz');

    // Teacher analytics
    Route::get('/teacher/analytics/{id}', [App\Http\Controllers\Teacher\AnalyticsController::class, 'show'])->name('teacher.analytics');
    Route::get('/teacher/analytics/{id_material}/student/{id_student}', [App\Http\Controllers\Teacher\AnalyticsController::class, 'studentDetail'])->name('teacher.analytics.student');

});

require __DIR__.'/auth.php';

