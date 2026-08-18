<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// public auth routes
Route::prefix('auth')->controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

// all protected routes
Route::middleware('auth:sanctum')->group(function(){
    // private auth routes
    Route::prefix('auth')->controller(AuthController::class)->group(function(){
        Route::post('logout', 'logout');
        Route::get('me', 'me');
    });

    // user management routes
    Route::prefix('users')->controller(UserController::class)->group(function(){
        Route::get('/', 'index')->middleware('permission:user.view');
        Route::post('/', 'store')->middleware('permission:user.create');
        Route::get('/{id}', 'show')->middleware('permission:user.view');
        Route::put('/{id}', 'update')->middleware('permission:user.update');
        Route::delete('/{id}', 'delete')->middleware('permission:user.delete');
        Route::put('/{id}/active', 'active')->middleware('permission:user.activate');
        Route::put('/{id}/deactive', 'deactive')->middleware('permission:user.deactivate');
    });

    // role management routes
    Route::prefix('roles')->controller(RoleController::class)->group(function(){
        Route::get('/', 'index')->middleware('permission:role.view');
        Route::post('/', 'store')->middleware('permission:role.create');
        Route::get('/{id}', 'show')->middleware('permission:role.view');
        Route::put('/{id}', 'update')->middleware('permission:role.update');
        Route::delete('/{id}', 'destroy')->middleware('permission:role.delete');
        Route::put('/{id}/sync-permissions', 'syncPermissions')->middleware('permission:role.update');
    });

    // permission management routes
    Route::prefix('permissions')->controller(PermissionController::class)->group(function(){
        Route::get('/', 'index')->middleware('permission:permission.view');
    });
});

