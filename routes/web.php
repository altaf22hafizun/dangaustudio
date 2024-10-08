<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\KaryaController;
use App\Http\Controllers\PameranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SenimanController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Middleware
Route::group(['middleware' => ['auth', 'verified']], function () {
    // Admin Routes
    Route::group(['middleware' => ['RoleMiddleware:admin']], function () {
        Route::get('/dashboard', function () {
            return view('admin.index');
        })->name('dashboard');
        //Event
        Route::resource('/admin/events', EventController::class);
        //Seniman
        Route::resource('/admin/seniman', SenimanController::class);
        //Berita
        Route::resource('/admin/berita', BeritaController::class);
        //Pameran
        Route::resource('/admin/pameran', PameranController::class);
        //Karya
        Route::resource('/admin/karya', KaryaController::class);
    });

    // User Routes
    Route::group(['middleware' => ['RoleMiddleware:user']], function () {
        Route::get('/user', function () {
            return view('user');
        })->name('user');
        // Settings
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});


require __DIR__ . '/auth.php';
