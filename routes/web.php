<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Passwords\Confirm;
use App\Livewire\Auth\Passwords\Email;
use App\Livewire\Auth\Passwords\Reset;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Verify;
use App\Livewire\Web\Home;
use App\Livewire\Web\Ingredients;
use App\Livewire\Web\Recipes;
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

/**
 * Home
 */
Route::get('/', Home::class)
    ->name('home');

/**
 * Recipes
 */
Route::get('recipes', Recipes::class)
    ->name('recipes');

/**
 * Ingredientes
 */
Route::get('ingredients', Ingredients::class)
    ->name('ingredients');

/**
 * Login
 */
Route::get('login', Login::class)
    ->middleware('guest')
    ->name('login');

/**
 * Register
 *
*/
/*
Route::get('register', Register::class)
    ->middleware('guest')
    ->name('register');
});
*/

/**
 * Password reset.
 */
Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');
Route::get('password/reset', Email::class)
    ->name('password.request');

/**
 * Auth routes.
 */
Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');
    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');
});

/**
 * Logout
 */
Route::match(['get', 'post'], 'logout', LogoutController::class)
    ->middleware('auth')
    ->name('logout');
