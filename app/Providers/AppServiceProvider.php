<?php

namespace App\Providers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewView;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('home.header', function ($view) {
            // Mendapatkan ID pengguna yang sedang login
            $userId = Auth::id();

            // Hitung jumlah item dalam keranjang berdasarkan pengguna
            $jumlahItem = Transaksi::where('id_user', $userId)->where('status', '3')->count();

            // Mengirim jumlah item ke view
            $view->with('jumlahItem', $jumlahItem);
        });
        View::composer('admin.header', function ($view) {
            // Mendapatkan ID pengguna yang sedang login
            $transaksi = Transaksi::where('status', '2')->count();
            // Mengirim jumlah item ke view
            $view->with('jumlahItem', $transaksi);
            $data = Transaksi::where('status', '2')->get();
            $view->with('data', $data);
        });
    }
}
