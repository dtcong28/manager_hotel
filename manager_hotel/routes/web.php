<?php

use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\TypeRoomController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\BookingController;
use App\Http\Controllers\Backend\BookingFoodController;
use App\Http\Controllers\Backend\FoodController;
use App\Http\Controllers\Backend\ProfileBackendController;
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

Route::get('/', function () {
    return Inertia::render('Admin/Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::prefix('admin')->get('/dashboard', function () {
    return Inertia::render('Admin/DashBoard/Index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/profile', [ProfileBackendController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileBackendController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileBackendController::class, 'destroy'])->name('profile.destroy');

    //employee
    Route::resource('employees', EmployeeController::class)->only(['index', 'create', 'edit', 'store', 'update', 'destroy']);

    //types room
    Route::resource('types-room', TypeRoomController::class)->only(['index', 'create', 'edit', 'store', 'update', 'destroy']);

    // rooms
    Route::resource('rooms', RoomController::class)->only(['index', 'create', 'edit', 'store', 'update', 'destroy']);

    // food
    Route::resource('food', FoodController::class)->only(['index', 'create', 'edit', 'store', 'update', 'destroy']);

    // customers
    Route::resource('customers', CustomerController::class)->only(['index', 'create', 'edit', 'store', 'update', 'destroy']);

    // booking rooms
    Route::resource('booking', BookingController::class)->only(['index', 'create', 'edit', 'store', 'update', 'destroy']);
    Route::get('/booking/filter-room', [BookingController::class, 'filterRoom'])->name('booking.filter_room');
    Route::get('/booking/edit/filter-room', [BookingController::class, 'editFilterRoom'])->name('booking.edit_filter_room');
    Route::get('/booking/{id}/bill', [BookingController::class, 'bill'])->name('booking.bill');
    Route::patch('/booking/{id}/update-payment', [BookingController::class, 'updatePayment'])->name('booking.update_payment');

    // booking food
    Route::get('booking/{id}/booking-food', [BookingFoodController::class, 'create'])->name('booking_food.create');
    Route::resource('booking_food', BookingFoodController::class)->only(['index', 'store']);
});

require __DIR__.'/auth.php';
