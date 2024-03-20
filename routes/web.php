<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


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



Route::get('/home', [HomeController::class, 'showHomePage'])->name('home');

Route::post('/home', [HomeController::class, 'submitForm']);

Route::get('/checkin', [Controller::class, 'showCheckin'])->name('checkin');

















