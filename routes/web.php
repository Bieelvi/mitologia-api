<?php

use App\Entities\Email;
use App\Entities\User;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Mail\VerifiedEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use LaravelDoctrine\ORM\Facades\EntityManager;

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

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/terms', [HomeController::class, 'index'])->name('home.index');

Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::post('/user', [UserController::class, 'store'])->name('user.store');

Route::get('/login/{provider}', function ($provider) {
    try {
        return Socialite::driver($provider)->redirect();
    } catch (\Throwable $e) {
        return back()->with('msgError', "Something happened when trying to login with {$provider}");
    }
});
 
Route::get('/login/{provider}/callback', [LoginController::class, 'loginSocialite']);

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

    Route::middleware('role.admin')->group(function() {
        Route::get('/admin', function() {
            dump('oi');
        });
    });
});