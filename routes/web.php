<?php

use App\Http\Controllers\{EmailController, LoginController, LogoutController, ProfileController, UserController};
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Livewire\{Home, Login, User};

Route::get('/home', Home::class)->name('home');
Route::get('/login', Login::class)->name('login.index');
Route::get('/user', User::class)->name('user.index');

Route::post('/user', [UserController::class, 'store'])->name('user.store');

Route::get('/login/{provider}', function ($provider) {
    try {
        return Socialite::driver($provider)->redirect();
    } catch (\Throwable $e) {
        session()->with('msgError', "Something happened when trying to login with {$provider}");
    }
})->name('login.provider');
 
Route::get('/login/{provider}/callback', [LoginController::class, 'loginSocialite']);

Route::post('/login', [LoginController::class, 'login'])->name('login.login');

Route::middleware('user.logged')->group(function() {    
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    Route::patch('/user/{id}', [UserController::class, 'update'])->name('user.update');
    
    Route::patch('/user/{id}/email', [EmailController::class, 'update'])->name('user.update.email');
    Route::post('/user/{id}/verified/email', [EmailController::class, 'send'])->name('user.send.email');
    Route::get('/user/{id}/verified/email', [EmailController::class, 'verified'])->name('user.verified.email');

    Route::middleware('role.admin')->group(function() {
        Route::get('/admin', function() {
            dump('oi');
        });
    });
});