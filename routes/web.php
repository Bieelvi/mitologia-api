<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Mail\VerifiedEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');

Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::post('/user', [UserController::class, 'store'])->name('user.store');

Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login.login');

Route::middleware('user.logged')->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home.index');
    
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    Route::patch('/user/{id}', [UserController::class, 'update'])->name('user.update');
    
    Route::patch('/user/{id}/email', [EmailController::class, 'update'])->name('user.update.email');
    Route::post('/user/{id}/verified/email', [EmailController::class, 'send'])->name('user.send.email');
    Route::get('/user/{id}/verified/email', [EmailController::class, 'verified'])->name('user.verified.email');
});