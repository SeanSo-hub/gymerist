<?php

use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckUserCapabilities;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin'),
        ['capabilities']
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('member', 'MemberCrudController');
    Route::crud('payment', 'PaymentCrudController');
    Route::crud('membership', 'MembershipCrudController');
    Route::crud('checkin', 'CheckinCrudController');

    Route::prefix('checkins')->group(function () {
        Route::get('/', [Controller::class, 'showCheckin'])->name('checkins.index');
        Route::get('/filter', [Controller::class, 'checkinFilter'])->name('checkins.filter');
    });
    
    Route::prefix('members')->group(function () {
        Route::get('/', [Controller::class, 'showMember'])->name('members.index');
        Route::get('/filter', [Controller::class, 'memberFilter'])->name('members.filter');
    });
    
    Route::prefix('payments')->group(function () {
        Route::get('/', [Controller::class, 'showPayment'])->name('payments.index');
        Route::get('/filter', [Controller::class, 'paymentFilter'])->name('payments.filter');
    });

    Route::prefix('cashflow')->group(function () {
        Route::get('/', [Controller::class, 'showCashflow'])->name('cashflow.index');
        Route::get('/filter', [Controller::class, 'cashflowFilter'])->name('cashflow.filter');
    });
    

}); // this should be the absolute last line of this file