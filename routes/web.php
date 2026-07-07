<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\JobController; 
use App\Http\Controllers\ApplicationController; 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/documentation' ,function () {
    return view('15-swaager::index');
});

Route::resource('jobs',JobController::class) ; 
Route::resource('companies',CompaniesController::class);
Route::resource('Application',ApplicationController::class);