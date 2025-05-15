<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminRegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\ChatController;


Route::prefix('admin')->name('admin.')->group(function () {
    // Authentication Routes
    Route::get('/', [AdminLoginController::class, 'index'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Dashboard (protected by admin auth)
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth:admin','can:manage-dashboard'])->name('dashboard');

    Route::prefix('tasks')->name('tasks.')->middleware(['auth:admin', 'can:manage-tasks'])->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/create', [TaskController::class, 'create'])->name('create');
        Route::post('/store', [TaskController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [TaskController::class, 'edit'])->name('edit');
        Route::put('/update/{task}', [TaskController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [TaskController::class, 'destroy'])->name('destroy');
        Route::get('/show/{id}', [TaskController::class, 'show'])->name('show');
    });

    Route::prefix('users')->name('users.')->middleware(['auth:admin', 'can:manage-users'])->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('update'); 
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('admins')->name('admins.')->middleware(['auth:admin','can:manage-admins'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/store', [AdminController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit');
        Route::put('/update/{admin}', [AdminController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [AdminController::class, 'destroy'])->name('destroy');
    });


    Route::prefix('roles')->name('roles.')->middleware(['auth:admin','can:manage-roles'])->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/store', [RoleController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
        Route::put('/update/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('destroy');
    });


   

    Route::prefix('comments')->name('comments.')->middleware(['auth'])->group(function () {
        Route::post('/store', [CommentController::class, 'store'])->name('store');
    });

    Route::prefix('chat')->name('chat.')->middleware(['auth:admin'])->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('index');
        Route::get('/{admin}', [ChatController::class, 'show'])->name('show');
        Route::post('/{admin}/store', [ChatController::class, 'store'])->name('store');
});

});
