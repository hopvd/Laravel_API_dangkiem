<?php

use App\Http\Controllers\Admin\User\LoginController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\OwnerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => 'admin'

], function ($router) {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');
    Route::get('/user-profile', [HomeController::class, 'userProfile']);

    Route::prefix('vehicle')->group(function () {
        Route::get('/', [VehicleController::class, 'index'])->name('vehicle.index');
        Route::get('/create', [VehicleController::class, 'create'])->name('vehicle.create');
        Route::post('/store', [VehicleController::class, 'store'])->name('vehicle.store');
        Route::get('/show/{id}', [VehicleController::class, 'show']);
        Route::post('/edit/{id}', [VehicleController::class, 'edit']);
        Route::post('/delete/{id}', [VehicleController::class, 'delete']);
    });
});
