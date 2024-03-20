<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

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

Route::middleware(Authenticate::class)->group(function () {
    Route::put('/tickets/{id}/{email}', [TicketController::class, 'update'])
        ->name('tickets.update');

    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
});

// Роуты логина
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/auth', [AuthController::class, 'auth'])->name('auth');

Route::get('/create', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
