<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Middleware
Route::group(['middleware' => ['auth', 'verified']], function () {
    // Admin Routes
    Route::group(['middleware' => ['RoleMiddleware:admin']], function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });

    // User Routes
    Route::group(['middleware' => ['RoleMiddleware:user']], function () {
        // Settings
        Route::get('/user', function () {
            return view('user');
        })->name('user');
    });
});


require __DIR__ . '/auth.php';
