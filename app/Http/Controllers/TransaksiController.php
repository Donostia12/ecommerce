<?php

namespace App\Http\Controllers;

use App\Models\pembayaran;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'id_produk' => 'required|exists:produk,id',
            'id_user' => 'required|exists:users,id',
            'amount' => 'required|integer|min:1',
            'penerima' => 'required|string|max:255',
            'total' => 'required|numeric|min:0',
        ]);

        // Simpan pesanan ke dalam database
        $transaksi = new Transaksi();
        $transaksi->id_produk = $request->id_produk;
        $transaksi->id_user = $request->id_user;
        $transaksi->amount = $request->amount;
        $transaksi->penerima = $request->penerima;
        $transaksi->total = $request->total;
        $transaksi->status = 3;
        $transaksi->save();

        // Redirect ke halaman produk dengan pesan sukses
        return redirect()->route('transaksi.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function index()
    {
        $userId = Auth::id(); // Mendapatkan ID pengguna yang sedang login
        $data = Transaksi::where('id_user', $userId)->whereIn('status', [2, 3])->get();
        $transaksi = [];

        foreach ($data as $item) {
            $produk = Produk::where('id', $item->id_produk)->first();
            $pembayaran = pembayaran::where('id_transaksi', $item->id)->first();

            $transaksi[] = [
                'produk' => $produk->name,
                'image' => $produk->image,
                'amount' => $item->amount,
                'status' => $item->status,
                'penerima' => $item->penerima,
                'desc' => $pembayaran ? $pembayaran->desc : "kosong",
                'total' => $item->total,
                'harga' => $produk->harga,
                'telp' => $item->telp,
                'create_at' => $item->created_at,
                'alamat' => $item->alamat,
                'id' => $item->id,
                'bukti' => $pembayaran ? $pembayaran->image : 'default_image.jpg' // Atur nilai default jika pembayaran null
            ];
        }

        // Mengambil data transaksi berdasarkan id_user
        return view('home.transaksi', compact('transaksi'));
    }


    public function index_selesai()
    {
        $userId = Auth::id(); // Mendapatkan ID pengguna yang sedang login
        $data = Transaksi::where('id_user', $userId)->where('status', 1)->get();
        $transaksi = [];

        foreach ($data as $item) {
            $produk = Produk::where('id', $item->id_produk)->first();
            $pembayaran = pembayaran::where('id_transaksi', $item->id)->first();

            $transaksi[] = [
                'produk' => $produk->name,
                'image' => $produk->image,
                'amount' => $item->amount,
                'status' => $item->status,
                'penerima' => $item->penerima,
                'desc' => $pembayaran ? $pembayaran->desc : "kosong",
                'total' => $item->total,
                'harga' => $produk->harga,
                'telp' => $item->telp,
                'create_at' => $item->created_at,
                'alamat' => $item->alamat,
                'id' => $item->id,
                'bukti' => $pembayaran ? $pembayaran->image : 'default_image.jpg' // Atur nilai default jika pembayaran null
            ];
        }

        // Mengambil data transaksi berdasarkan id_user
        return view('home.transaksi', compact('transaksi'));
    }

    public function transaksi(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'alamat' => 'required',
            'telp' => 'required',
            'bank' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png|max:10240'
        ]);

        // Inisialisasi path gambar


        // Upload file bukti pembayaran jika ada
        if ($request->hasFile('image')) {
            // Dapatkan file gambar
            $file = $request->file('image');

            // Buat nama file unik dengan hash
            $fileName = time() . '_' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

            // Simpan gambar di direktori 'public/images' dan ambil path gambar
            $imagePath = $file->storeAs('images', $fileName, 'public');
        }

        // Update atau buat data pembayaran
        $bayar = pembayaran::where('id_transaksi', $id)->first();
        if ($bayar) {
            // Jika ada gambar lama, hapus sebelum melakukan update
            if ($bayar->image && Storage::disk('public')->exists($bayar->image)) {
                Storage::disk('public')->delete('images/' . $bayar->image);
            }

            // Update data pembayaran dengan gambar baru
            $bayar->update([
                'bank' => $request->bank,
                'image' => $fileName,
                'desc' => $request->desc, // Simpan path gambar yang di-upload
                'id_transaksi' => $id
            ]);
        } else {
            // Buat data pembayaran baru jika belum ada
            pembayaran::create([
                'desc' => $request->desc,
                'bank' => $request->bank,
                'image' => $fileName,
                'id_transaksi' => $id
            ]);
        }

        // Update data transaksi
        $transaksi = Transaksi::find($id);
        $transaksi->update([
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'status' => "2"
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil diperbarui');
    }

    public function accept($id)
    {
        $transaksi = Transaksi::find($id);
        $produk = Produk::find($transaksi->id_produk);

        // Cek jika stock lebih kecil dari amount
        if ($produk->stock < $transaksi->amount) {
            return redirect()->back()->with('error', 'Transaksi gagal: Stok produk tidak mencukupi.');
        }

        // Update stock produk
        $produk->update([
            'stock' => $produk->stock - $transaksi->amount
        ]);
        Penjualan::create(
            [
                'id_produk' => $transaksi->id_produk,
                'sold' => $transaksi->amount
            ]
        );
        // Update status transaksi
        $transaksi->update([
            'status' => "1"
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil diperbarui');
    }
    public function accept_combo(Request $request)
    {

        $id_transaksiarray = explode(',', $request->id_transaksi);
        foreach ($id_transaksiarray as $item) {
            $transaksi =  Transaksi::where('id', $item)->first();
            $transaksi->update([
                'status' => "1"
            ]);
            Penjualan::create(
                [
                    'id_produk' => $transaksi->id_produk,
                    'sold' => $transaksi->amount
                ]
            );
        }


        return redirect()->back()->with('success', 'Transaksi berhasil diperbarui');
    }
    public function index_transaksi()
    {
        $transaksi = transaksi::all();

        $data = [];
        foreach ($transaksi as $item) {
            $produk = Produk::where('id', $item->id_produk)->first();
            $user = User::where('id', $item->id_user)->first();
            if ($item->status == 3) {
                $status = "Data Pesanan belum lengkap";
            } elseif ($item->status == 2) {
                $status = "Menunggu Pembayaran di terima";
            } elseif ($item->status == 1) {
                $status = "Pesanan Selesai";
            }
            $data[] = [
                'name' => $produk->name,
                'pembeli' => $user->name,
                'jumlah' => $item->amount,
                'status' => $status,
                'tgltransaksi' => $item->created_at
            ];
        }
        return view('admin.transaksi', compact('data'));
    }

    public function ajax_transaksi($id)
    {
        $data = transaksi::find($id);
        return response()->json($data);
    }
    public function combo_transaksi(Request $request)
    {

        // Validasi request
        $request->validate([
            'id_transaksi' => 'required|string',
            'alamat' => 'required|string',
            'telp' => 'required|string',
            'gambar' => 'required|mimes:jpg,jpeg,png|max:10240'
        ]);

        // Memecah id_transaksi menjadi array
        $idTransaksiArray = explode(',', $request->id_transaksi);
        if ($request->hasFile('gambar')) {
            // Dapatkan file gambar
            $file = $request->file('gambar');

            $fileName = time() . '_' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

            $imagePath = $file->storeAs('images', $fileName, 'public');
        }

        foreach ($idTransaksiArray as $idTransaksi) {
            // Temukan transaksi berdasarkan ID
            $transaksi = Transaksi::find($idTransaksi);

            if ($transaksi) {
                // Update transaksi dengan data alamat dan telp
                $transaksi->update([
                    'alamat' => $request->alamat,
                    'telp' => $request->telp,
                    'status' => "2"
                ]);
            } else {
                // Jika transaksi tidak ditemukan, tambahkan log atau beri respon error
                return redirect()->back()->with('error', 'Gagal di perbaharui');
            }
        }
        pembayaran::create([
            'id_transaksi' => $transaksi->id,
            'desc' => $request->deskripsi,
            'bank' => $request->bank,
            'combo' => $request->id_transaksi,
            'image' => $fileName
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil diperbarui');
    }
}
