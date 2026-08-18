<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// auth routes
Route::prefix('auth')->group(function(){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function(){
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

// user management routes
Route::prefix('users')->middleware('auth:sanctum')->group(function(){
    Route::get('/', [UserController::class, 'index'])->middleware('permission:user.view');
    Route::post('/', [UserController::class, 'store'])->middleware('permission:user.create');
    Route::get('/{id}', [UserController::class, 'show'])->middleware('permission:user.view');
    Route::put('/{id}', [UserController::class, 'update'])->middleware('permission:user.update');
    Route::delete('/{id}', [UserController::class, 'delete'])->middleware('permission:user.delete');
    Route::put('/{id}/active', [UserController::class, 'active'])->middleware('permission:user.activate');
    Route::put('/{id}/deactive', [UserController::class, 'deactive'])->middleware('permission:user.deactivate');
});

