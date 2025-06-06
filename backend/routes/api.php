<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/login', [LoginController::class, 'login']);

Route::get('api/admin/stats', [AdminController::class, 'getStats']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/usuarios', [App\Http\Controllers\UsuarioController::class, 'index']);
    Route::post('/usuarios', [App\Http\Controllers\UsuarioController::class, 'store']);
});
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/user', function (Request $request) {
    return $request->user();
});
