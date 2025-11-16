<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\OfficeSupplies;

// Redirect root to login
Route::get('/', fn() => redirect('/login'));

// Registration
Route::get('/register', [AuthController::class, 'registerForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Office Supplies Inventory (Protected by auth middleware)
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/inventory', \App\Livewire\OfficeSupplies::class)->name('inventory');
    Route::get('/reports', fn() => view('reports'))->name('reports');
});
