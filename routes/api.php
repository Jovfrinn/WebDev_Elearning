<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\backend\MateriUserController;
use App\Http\Controllers\API\backend\PostMateriController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

Route::get('material', [PostMateriController::class, 'index']);
Route::get('materialUser', [MateriUserController::class, 'index']);


