<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('programs', ProgramController::class);
    Route::apiResource('reports', ReportController::class);
    Route::post('logout', [AuthController::class, 'logout']);
});
