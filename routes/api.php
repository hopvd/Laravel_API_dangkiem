<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\v1\CertificateController;
use App\Http\Controllers\Api\v1\OwnerController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:api')->get('/check-login', [AuthController::class, 'checkLogin']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::get('/check-login', [AuthController::class, 'checkLogin']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/change-pass', [AuthController::class, 'changePassWord']);
});

Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::get('/vehicle/{id}', [VehicleController::class, 'show']);
    Route::post('/vehicle', [VehicleController::class, 'store']);
    Route::put('/vehicle/{id}', [VehicleController::class, 'update']);
    Route::delete('/vehicle/{id}', [VehicleController::class, 'destroy']);
    Route::get('/vehicles/by_owner_id', action: [VehicleController::class, 'getByOwnerId']);
    Route::get('/vehicles/by_license_plate', action: [VehicleController::class, 'getByLicensePlate']);
});

Route::group([
    'middleware' => 'api',
], function ($router) {
    // Role 1 use
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::post('/user', [UserController::class, 'store']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);

    // Role 2 use
    Route::get('/user-me/', [UserController::class, 'showme']);
});

Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::get('/owners', [OwnerController::class, 'index']);
    Route::get('/owner/{id}', [OwnerController::class, 'show']);
    Route::post('/owner', [OwnerController::class, 'store']);
    Route::put('/owner/{id}', [OwnerController::class, 'update']);
    Route::delete('/owner/{id}', [OwnerController::class, 'destroy']);
    Route::get('/owner/{id}/vehicles', [VehicleController::class, 'getByOwnerId']);
});

Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::get('/certificates', [CertificateController::class, 'index']);
    Route::post('/certificate/getlist', [CertificateController::class, 'getList']);
    Route::get('/certificate/{id}', [CertificateController::class, 'show']);
    Route::post('/certificate', [CertificateController::class, 'store']);
    Route::put('/certificate/{id}', [CertificateController::class, 'update']);
    Route::delete('/certificate/{id}', [CertificateController::class, 'destroy']);
});

