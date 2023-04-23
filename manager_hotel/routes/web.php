<?php

use App\Http\Controllers\Frontend\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\RoomFEController;
use App\Http\Controllers\Frontend\RestaurantController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\ProfileCustomerController;
use App\Http\Controllers\Frontend\Auth\PasswordController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

//Route::get('/', function () {
//    return Inertia::render('Admin/Auth/Login', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::group(['as' => 'web.'], function () {
    // Auth
    Route::namespace('Auth')->middleware('guest:web')->group(function (){
        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');

        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('profile', [ProfileCustomerController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileCustomerController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileCustomerController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('booking')->group(function () {
        Route::get('/filter-room', [\App\Http\Controllers\Frontend\BookingController::class, 'filterRoom'])->name('booking.filter_room');
        Route::get('/food', [\App\Http\Controllers\Frontend\BookingController::class, 'bookFood'])->name('booking.food');
        Route::get('/confirm', [\App\Http\Controllers\Frontend\BookingController::class, 'confirm'])->name('booking.confirm');
        Route::get('/payment', [\App\Http\Controllers\Frontend\BookingController::class, 'payment'])->name('booking.payment');
        Route::get('/complete', [\App\Http\Controllers\Frontend\BookingController::class, 'complete'])->name('booking.complete');
        Route::post('/webhook', [\App\Http\Controllers\Frontend\BookingController::class, 'webhook'])->name('booking.webhook');
        Route::resource('/', \App\Http\Controllers\Frontend\BookingController::class)->only(['store']);
    });

    Route::prefix('room')->as('rooms.')->group(function () {
        Route::resource('/', RoomFEController::class)->only(['index']);
        Route::get('/{id}', [RoomFEController::class, 'detail'])->name('detail');
    });

    Route::resource('/restaurant', RestaurantController::class)->only(['index']);

    Route::resource('/about', AboutController::class)->only(['index']);

    Route::resource('/contact', ContactController::class)->only(['index']);
    Route::post('/contact/feed-back', [ContactController::class, 'feedBack'])->name('feedback');
});
