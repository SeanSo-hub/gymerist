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

Route::prefix('checkins')->group(function () {
    Route::get('/', [Controller::class, 'showCheckin'])->name('checkins.index');
    Route::get('/filter', [Controller::class, 'filter'])->name('checkins.filter');
});

Route::prefix('members')->group(function () {
    Route::get('/', [Controller::class, 'showMember'])->name('members.index');
    Route::get('/filter', [Controller::class, 'filter'])->name('members.filter');
});

Route::prefix('payments')->group(function () {
    Route::get('/', [Controller::class, 'showPayment'])->name('payments.index');
    Route::get('/filter', [Controller::class, 'filter'])->name('payments.filter');
});

















