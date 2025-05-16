<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\auth\UserLoginController;
use App\Http\Controllers\User\auth\RegisterController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\TaskController;
use App\Http\Controllers\ChatController;


Route::get('/',[UserLoginController::class,'index'])->middleware('guest')->name('login');
Route::get('/register',[RegisterController::class,'index'])->middleware('guest')->name('register');

Route::post('/',[UserLoginController::class,'login'])->middleware('guest')->name('login.post');
Route::post('/register',[RegisterController::class,'register'])->middleware('guest')->name('register.post');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::post('/logout',[UserLoginController::class,'logout'])->middleware('auth')->name('logout');

Route::get('/tasks',[TaskController::class,'index'])->middleware('auth')->name('tasks.index');
Route::get('/tasks/show/{id}',[TaskController::class,'show'])->middleware('auth')->name('tasks.show');

Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{admin}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{admin}', [ChatController::class, 'store'])->name('chat.store');
});
