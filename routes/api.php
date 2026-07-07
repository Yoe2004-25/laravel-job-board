<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApplicationApiController;
use App\Http\Controllers\Api\CompaniesApiController;
use App\Http\Controllers\Api\JobApiController;
use App\Http\Controllers\Auth\AuthApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register', [AuthApiController::class, 'register']);
Route::post('login', [AuthApiController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthApiController::class, 'logout']);
    Route::get('user', [AuthApiController::class, 'user']);

    Route::apiResource('applications', ApplicationApiController::class);
    Route::apiResource('companies', CompaniesApiController::class);
    Route::apiResource('jobs', JobApiController::class);
});