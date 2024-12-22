<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function index()
    {
        // Ambil 8 produk secara acak untuk rekomendasi
        $recomment = Produk::where('status', '!=', 2)->inRandomOrder()->take(8)->get();

        $data = Produk::where('status', '!=', 2)->get();

        return view('home.Index', compact('recomment', 'data'));
    }

    public function detail($id)
    {
        $data = Produk::find($id);
        return view('home.detail', compact('data'));
    }
    public function profil()
    {

        return view('home.profil');
    }

    public function search(Request $request)
    {
        // Ambil query dari input
        $query = $request->input('query');

        // Cari produk berdasarkan nama yang mirip dengan query
        $products = Produk::where('name', 'LIKE', "%{$query}%")->get();

        // Kembalikan view dengan hasil pencarian
        return view('home.search', compact('products', 'query'));
    }

    public function homepassword()
    {
        return view('home.setting');
    }
    public function homegantipassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'sandilama' => 'required',
            'sandibaru' => 'required',
            'sandivalid' => 'required|same:sandibaru', // Harus sama dengan sandibaru
        ]);

        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Memeriksa apakah sandi lama benar
        if (!Hash::check($request->sandilama, $user->password)) {
            return redirect()->back()->withErrors(['sandilama' => 'Kata sandi lama tidak sesuai.']);
        }

        // Memperbarui kata sandi
        $user->password = Hash::make($request->sandibaru);
        $user->save();

        return redirect()->back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
    //ket di pembayaran 
    //ganti password
}
