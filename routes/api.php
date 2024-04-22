<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/users', [App\Http\Controllers\Api\UserController::class, 'index']);

Route::get('/streams', [App\Http\Controllers\Api\StreamController::class, 'index']);
Route::get('/divisions', [App\Http\Controllers\Api\DivisionController::class, 'index']);
Route::get('/students', [App\Http\Controllers\Api\StudentsController::class, 'index']);
