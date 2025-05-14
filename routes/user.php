<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\auth\UserLoginController;
use App\Http\Controllers\User\auth\RegisterController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\TaskController;


Route::get('/',[UserLoginController::class,'index'])->name('login');
Route::get('/register',[RegisterController::class,'index'])->name('register');

Route::post('/',[UserLoginController::class,'login'])->name('login.post');
Route::post('/register',[RegisterController::class,'register'])->name('register.post');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::post('/logout',[UserLoginController::class,'logout'])->middleware('auth')->name('logout');

Route::get('/tasks',[TaskController::class,'index'])->middleware('auth')->name('tasks.index');
Route::get('/tasks/show/{id}',[TaskController::class,'show'])->middleware('auth')->name('tasks.show');