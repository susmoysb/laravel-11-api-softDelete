<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', UserController::class)->only(['index', 'show', 'destroy']);

// In Laravel 11, when using route model binding, soft‐deleted models are automatically excluded from queries by default.
// To include soft‐deleted models in queries, chain the withTrashed() method to the route definition.
Route::post('/users/{user}/restore', [UserController::class, 'restore'])->withTrashed();
