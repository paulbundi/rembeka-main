<?php

use App\Http\Controllers\Corporate\CorporateMemberController;
use App\Http\Controllers\Corporate\CorporateOrderController;
use Illuminate\Support\Facades\Route;

Route::get('corporate-orders', [CorporateOrderController::class, 'index'])
    ->name('corporate.orders');

Route::get('corporate-orders/{order}', [CorporateOrderController::class, 'show'])
    ->name('corporate-orders.show');

Route::get('members', [CorporateMemberController::class, 'index'])
    ->name('members.index');

Route::get('/corporate-members/create', [CorporateMemberController::class, 'create'])
    ->name('corporate-members.create');
