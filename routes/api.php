<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// /v1/auth
Route::prefix('v1/auth')->group(function () {
    // login y register
    Route::post('/login', [AuthController::class, 'login']);
    Route::post("/register", [AuthController::class, 'registro']);

    // /v1/auth/perfil y /v1/auth/logout
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/perfil', [AuthController::class, "miPerfil"]);
        Route::post('/logout', [AuthController::class, "cerrar"]);
    });
});
