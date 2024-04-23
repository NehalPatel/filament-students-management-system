<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/users', [App\Http\Controllers\Api\UserController::class, 'index']);

Route::resource('/streams', App\Http\Controllers\Api\StreamController::class);
Route::resource('/divisions', App\Http\Controllers\Api\DivisionController::class);

Route::resource('/students', App\Http\Controllers\Api\StudentsController::class);
