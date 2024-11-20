<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//projects
Route::apiResource('/projects', App\Http\Controllers\Api\ProjectController::class);
Route::apiResource('/orders', App\Http\Controllers\Api\OrderController::class);
Route::apiResource('/admins', App\Http\Controllers\Api\AdminController::class);
