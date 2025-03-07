<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\DetailPesananController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KaryaController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PameranController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SenimanController;
use App\Http\Middleware\RoleMiddleware;
use App\Models\DetailPesanan;
use App\Models\Pameran;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/tentang', [LandingController::class, 'tentang'])->name('tentang');
//Seniman
Route::get('/seniman', [SenimanController::class, 'landing'])->name('seniman.landing');
Route::get('/seniman/{slug}', [SenimanController::class, 'show'])->name('seniman.show');
//Berita
Route::get('/berita', [BeritaController::class, 'landing'])->name('berita.landing');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');
//Event
Route::get('/event', [EventController::class, 'landing'])->name('event.landing');
Route::get('/event/{slug}', [EventController::class, 'show'])->name('event.show');
//Karya
Route::get('/galery', [KaryaController::class, 'landing'])->name('galery.landing');
Route::get('/galery/{slug}', [KaryaController::class, 'show'])->name('galery.show');
//Pameran
Route::get('/pameran', [PameranController::class, 'landing'])->name('pameran.landing');
Route::get('/pameran/{slug}', [PameranController::class, 'show'])->name('pemeran.show');

Route::get('/test', [PesananController::class, 'test']);

// Middleware
Route::group(['middleware' => ['auth', 'verified']], function () {
    // Admin Routes
    Route::group(['middleware' => ['RoleMiddleware:admin']], function () {
        Route::get('/admin', [LandingController::class, 'admin'])->name('dashboard');
        //Event
        Route::resource('/admin/events', EventController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
        //Seniman
        Route::resource('/admin/seniman', SenimanController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
        //Berita
        Route::resource('/admin/berita', BeritaController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
        //Pameran
        Route::resource('/admin/pameran', PameranController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
        //Karya
        Route::resource('/admin/karya', KaryaController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
        //Pesanan
        Route::get('/admin/pesanan', [PesananController::class, 'admin'])->name('pesanan.admin');
        Route::get('/admin/pesanan/{id}/edit', [PesananController::class, 'edit'])->name('pesanan.admin.edit');
        Route::put('/admin/pesanan/{id}', [PesananController::class, 'update'])->name('pesanan.admin.update');
        //User
        Route::get('/admin/user', [LandingController::class, 'adminUser']);
        //Laporan
        Route::get('/admin/laporan/penghasilan', [LaporanController::class, 'penghasilan'])->name('laporan.penghasilan');
        Route::get('/admin/laporan/transaksi', [LaporanController::class, 'transaksi'])->name('laporan.transaksi');
    });

    // User Routes
    Route::group(['middleware' => ['RoleMiddleware:user']], function () {

        // Settings
        Route::get('/user/account', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/user/account/edit-profile', [ProfileController::class, 'updateprofile'])->name('profile.update-profile');
        Route::post('/user/account/update-password', [ProfileController::class, 'updatepassword'])->name('profile.update-password');

        //Keranjang
        Route::resource('/cart', KeranjangController::class)->only('index', 'store', 'destroy');

        // Pesanan
        Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
        Route::post('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
        Route::post('/get-shipping-services', [PesananController::class, 'getShippingServices'])->name('getShippingServices');
        Route::post('/checkout', [PesananController::class, 'checkout'])->name('pesanan.checkout');

        //Detail Pesanan
        Route::get('pembayaran/pesanan/{id}', [PesananController::class, 'detailPembayaran'])->name('pesanan.detail');
        Route::post('/pesanan/{id}/konfirmasi-selesai', [PesananController::class, 'konfirmasiSelesai'])->name('pesanan.konfirmasi');

        // Pembayaran
        Route::get('/pembayaran', [PesananController::class, 'pembayaran'])->name('pesanan.pembayaran');

        //Riwayat Pesanan
        Route::get('/user/riwayat-pesanan', [PesananController::class, 'riwayatPesanan'])->name('pesanan.riwayat');
    });
});


require __DIR__ . '/auth.php';
