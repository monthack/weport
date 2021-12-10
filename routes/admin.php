<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', [HomeController::class, 'index'])->name('admin.home');
Route::get('list-users', [UserController::class,'listUsers'])->name('list-users');
Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.users');
Route::get('/list-roles', [RolController::class, 'listRoles'])->name('list-roles');

Route::get('list-users-by-roles', [UserController::class,'listUsersByRoles'])->name('list-users-by-roles');
