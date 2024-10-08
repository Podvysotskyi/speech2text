<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Domain\HomeController;
use App\Http\Controllers\Domain\RecordsController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomeController::class)->name('welcome');
Route::get('/home', HomeController::class)->name('home');
Route::get('/records', [RecordsController::class, 'records'])->name('records');
Route::post('/records', [RecordsController::class, 'upload']);
Route::get('/records/{record}', [RecordsController::class, 'record'])->name('record');
Route::get('/records/{record}/export', [RecordsController::class, 'export'])->name('export-record');

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout']);
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
