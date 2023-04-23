<?php

use App\Http\Controllers\Backend\TypeRoomController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\BookingController;
use App\Http\Controllers\Backend\BookingFoodController;
use App\Http\Controllers\Backend\FoodController;
use App\Http\Controllers\Backend\HotelController;
use App\Http\Controllers\Backend\ProfileBackendController;
use App\Http\Controllers\Backend\DashBoardController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\FeedBackController;
use App\Http\Controllers\Backend\PermissionsController;
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

//Route::prefix('admin')->get('/dashboard', function () {
//    return Inertia::render('Admin/DashBoard/Index');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->middleware(['auth', 'role:admin|manager|staff'])->group(function () {
    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');

    Route::resource('/users', UserController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/permissions', PermissionsController::class);

    Route::get('/profile', [ProfileBackendController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileBackendController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileBackendController::class, 'destroy'])->name('profile.destroy');

    //types room
    Route::resource('types-room', TypeRoomController::class)->only(['index', 'create', 'edit', 'store', 'update', 'destroy']);

    // rooms
    Route::resource('rooms', RoomController::class)->only(['index', 'create', 'edit', 'store', 'update', 'destroy']);

    // food
    Route::resource('food', FoodController::class)->only(['index', 'create', 'edit', 'store', 'update', 'destroy']);

    // customers
    Route::resource('customers', CustomerController::class)->only(['index', 'create', 'edit', 'store', 'update', 'destroy']);

    //hotel
    Route::resource('hotel', HotelController::class)->only(['create', 'edit', 'store', 'update', 'destroy']);

    // booking rooms
    Route::resource('booking', BookingController::class)->only(['index', 'create', 'edit', 'store', 'update', 'destroy']);
    Route::get('/booking/filter-room', [BookingController::class, 'filterRoom'])->name('booking.filter_room');
    Route::get('/booking/edit/filter-room', [BookingController::class, 'editFilterRoom'])->name('booking.edit_filter_room');
    Route::get('/booking/{id}/detail', [BookingController::class, 'detail'])->name('booking.detail');
    Route::patch('/booking/{id}/update-status', [BookingController::class, 'updateStatus'])->name('booking.update_status');

    // booking food
    Route::get('booking/{id}/booking-food', [BookingFoodController::class, 'create'])->name('booking_food.create');
    Route::resource('booking_food', BookingFoodController::class)->only(['index', 'store']);

    // feed back
    Route::resource('feed-back', FeedBackController::class)->only(['index', 'destroy']);
});

require __DIR__ . '/auth.php';
