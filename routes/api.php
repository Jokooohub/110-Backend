<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\RoomController;
use App\Models\Admin;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Public APIs
Route::post('/login', [AuthController::class, 'login'])->name('user.login');
Route::post('/user', [UserController::class, 'store'])->name('user.store');

//admin
Route::post('/adminlogin', [AuthController::class, 'loginAdmin'])->name('admin.login');
Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');

//booking
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking', [BookingController::class, 'index']);

//room
Route::post('/room', [RoomController::class, 'store'])->name('room.store');
Route::get('/room', [RoomController::class, 'index']);
Route::delete('/room/{id}', [RoomController::class, 'destroy'])->name('room.destroy');


//Private APIs
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::controller(UserController::class)->group(function () {
        Route::get('/user',               'index');
        Route::get('/user/{id}',          'show');
        Route::put('/user/{id}',          'update')->name('user.update');
        Route::put('/user/email/{id}',    'email')->name('user.email');
        Route::put('/user/password/{id}', 'password')->name('user.password');
        // Route::put('/user/image/{id}', 'image')->name('user.image');
        // Route::delete('/user/{id}',        'destroy');
    });

    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin',               'index');
        Route::controller(BookingController::class)->group(function () {
            // Route::get('/booking',               'index');
            

        });
    });

    // // User Specific APIs
    // Route::get('/profile/show',         [ProfileController::class, 'show']);
    // Route::put('/profile/image',        [ProfileController::class, 'image'])->name('profile.image');
});