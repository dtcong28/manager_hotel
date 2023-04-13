<?php

use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\TypeRoomController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\BookingController;
use App\Http\Controllers\Backend\BookingFoodController;
use App\Http\Controllers\Backend\FoodController;
use App\Http\Controllers\Backend\HotelController;
use App\Http\Controllers\Backend\ProfileBackendController;
use App\Http\Controllers\Backend\DashBoardController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\RoomFEController;
use App\Http\Controllers\Frontend\RestaurantController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ContactController;
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

//Route::prefix('admin')->get('/dashboard', function () {
//    return Inertia::render('Admin/DashBoard/Index');
//})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('admin/dashboard',[DashBoardController::class, 'index'])->name('dashboard');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

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
});

Route::group(['as' => 'web.'], function () {
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
});

require __DIR__ . '/auth.php';
