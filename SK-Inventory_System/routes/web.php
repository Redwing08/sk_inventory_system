<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Direct visitors from homepage to login
Route::get('/', function () {
    return redirect()->route('login');
});

// 1. GET: Show the SK Login Form Page
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// 2. POST: Handle Form Submission when user clicks "Sign In"
Route::post('/login', [AuthController::class, 'login']);

// 3. POST: Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 4. PROTECTED DASHBOARD ROUTE (Only logged-in users can enter)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('page.dashboard');
    })->name('dashboard');

    // // New User Entry / Management Page Route
    // Route::get('/useraccount', function () {
    //     return view('page.user');
    // })->name('useraccount');

    // 1. GET: Show the Users & Roles Management page
    Route::get('/useraccount', [AuthController::class, 'showUserPage'])->name('useraccount');
    // 2. POST: Save the new user into the database (Fixes the 405 error!)
    Route::post('/useraccount', [AuthController::class, 'storeUser'])->name('useraccount.store');
    // DELETE: Delete an SK User
    Route::delete('/useraccount/{id}', [AuthController::class, 'deleteUser'])->name('useraccount.delete');
    // PUT: Update SK User Entry
    Route::put('/useraccount/{id}', [AuthController::class, 'updateUser'])->name('useraccount.update');

    Route::get('/inventory', [AuthController::class, 'showInventory'])->name('inventory.index');
    Route::post('/inventory', [AuthController::class, 'storeInventory'])->name('inventory.store');
    Route::put('/inventory/{id}', [AuthController::class, 'updateInventory'])->name('inventory.update');
    Route::delete('/inventory/{id}', [AuthController::class, 'deleteInventory'])->name('inventory.delete');
});