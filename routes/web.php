<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/health', function() {
    return response()->json([
        'status' => 'healthy',
        'version' => '1.0.0',
        'timestamp' => now()->toISOString()
    ], 200);
});
