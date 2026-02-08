<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrganController;
use App\Http\Controllers\Api\OrganDonationController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\PatientWaitlistController;
use App\Http\Controllers\Api\TransplantScheduleController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('manual.auth')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('/charts', [DashboardController::class, 'charts']);
    });


    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::put('users/{id}/change-password', [UserController::class, 'changePassword']);

        Route::apiResource('organs', OrganController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Shared Routes
    |--------------------------------------------------------------------------
    */
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('patient-waitlists', PatientWaitlistController::class);
    Route::apiResource('organ-donations', OrganDonationController::class);
    Route::apiResource('transplants-schedules', TransplantScheduleController::class);
});