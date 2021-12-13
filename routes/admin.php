<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', [HomeController::class, 'index'])->name('admin.home');
Route::get('/list-roles', [RolController::class, 'listRoles'])->name('list-roles');
Route::get('users-index', [UserController::class, 'index'])->name('admin.users.index');
Route::get('list-users', [UserController::class,'listUsers'])->name('list-users');
Route::post('users-store/', [UserController::class, 'store'])->name('admin.users.store');
Route::post('users-validate/{id}', [UserController::class, 'userValidate'])->name('admin.users.validate');
Route::post('users-update/{id}', [UserController::class, 'update'])->name('admin.users.update');
Route::post('users-delete/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
