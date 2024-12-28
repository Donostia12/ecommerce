<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\LoginMiddleware;
use App\Models\Penjualan;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Route;
use PHPUnit\Event\Code\Test;

Route::get('/newpdf', [PenjualanController::class, 'print_pdf'])->name('penjualan.pdf');
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::post('/login', [UserController::class, 'Login'])->name('login');
Route::post('/register', [UserController::class, 'Register'])->name('register');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::post('/combo_transaksi', [TransaksiController::class, 'combo_transaksi'])->name('combo_transaksi');
Route::get('produk-detail/{id}', [IndexController::class, 'detail'])->name('produk-detail');
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::get('/transaksi_selesai', [TransaksiController::class, 'index_selesai'])->name('transaksi.index.selesai');
Route::get('/search-products', [IndexController::class, 'search'])->name('index.search');
Route::get('/verify/{id}', [UserController::class, 'verify'])->name('verify.user');
Route::get('/forget-password/{id}', [UserController::class, 'forget_password_user'])->name('forget.user');
Route::post('/reset-password-user/{id}', [UserController::class, 'reset_password_user'])->name('reset.password.user');
Route::get('forget-password', [UserController::class, 'forget_password'])->name('forget.password');
Route::post('/reset-password', [UserController::class, 'reset_password'])->name('reset.password');
Route::middleware([AdminMiddleware::class])->group(function () {
    Route::post('/transaksi-accept/{id}', [TransaksiController::class, 'accept'])->name('transaksi.accept');
    Route::post('/transaksi-accept-combo', [TransaksiController::class, 'accept_combo'])->name('transaksi.accept.combo');
    Route::post('/transaksi-reject-combo', [TransaksiController::class, 'reject_combo'])->name('transaksi.reject.combo');
    Route::get('/transaksi_index', [TransaksiController::class, 'index_transaksi'])->name('transaksi.admin.index');
    Route::resource('produk', ProdukController::class);
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::resource('pembayaran', PembayaranController::class);
    Route::resource('penjualan', PenjualanController::class);
    Route::get('/penjualan-bulanan', [PenjualanController::class, 'penjualanBulanan'])->name('penjualan.bulanan');
    Route::get('/produk/status/{id}/{status}', [ProdukController::class, 'status'])->name('produk.status');
});
Route::middleware([LoginMiddleware::class])->group(function () {
    Route::put('/transaksi/{id}', [TransaksiController::class, 'transaksi'])->name('transaksi.update');
    Route::get('/profil', [IndexController::class, 'profil'])->name('profil');
    Route::get('/setting', [IndexController::class, 'homepassword'])->name('home.setting');
    Route::post('/home', [IndexController::class, 'homegantipassword'])->name('home.gantipass');
});
