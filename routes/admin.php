<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminRegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;


Route::prefix('admin')->name('admin.')->group(function () {
    // Authentication Routes
    Route::get('/', [AdminLoginController::class, 'index'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Dashboard (protected by admin auth)
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth:admin')->name('dashboard');

    Route::prefix('tasks')->name('tasks.')->middleware('auth:admin')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/create', [TaskController::class, 'create'])->name('create');
        Route::post('/store', [TaskController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [TaskController::class, 'edit'])->name('edit');
        Route::put('/update/{task}', [TaskController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [TaskController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('users')->name('users.')->middleware('auth:admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('update'); 
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

});
