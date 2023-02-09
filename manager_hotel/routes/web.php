<?php

use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\TypeRoomController;
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
    return Inertia::render('Admin/Employees/Index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/profile', [ProfileBackendController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileBackendController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileBackendController::class, 'destroy'])->name('profile.destroy');

    //employee
    Route::resource('employees', EmployeeController::class)->only(['index', 'create', 'edit', 'store', 'update', 'destroy']);

    //types room
    Route::resource('types-room', TypeRoomController::class)->only(['index', 'create', 'edit', 'store', 'update', 'destroy']);
});

require __DIR__.'/auth.php';
