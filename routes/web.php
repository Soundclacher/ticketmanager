<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

// Админские роуты манипуляций с тикетами
Route::middleware(Authenticate::class)->group(function () {
    Route::put('/tickets/{id}/{email}', [TicketController::class, 'update'])
        ->name('tickets.update');

    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/answer/{id}/{email}', [TicketController::class, 'send'])->name('tickets.send');
});

// Роуты логина
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/auth', [AuthController::class, 'auth'])->name('auth');

// Пользовательские роуты создания заявки
Route::get('/create', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
