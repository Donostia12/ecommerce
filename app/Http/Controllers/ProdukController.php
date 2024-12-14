<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Produk::all();
        return view('admin.Produk', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.Produk-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data form
        $request->validate([
            'nama' => 'required|string|max:255',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:10240', // Batas ukuran file 10MB
            'deskripsi' => 'required',
            'harga' => 'required|numeric|min:0',
        ]);

        // Handle pengunggahan gambar
        if ($request->hasFile('image')) {
            // Dapatkan file gambar
            $file = $request->file('image');

            // Buat nama file unik dengan hash
            $fileName = time() . '_' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

            // Simpan gambar di direktori 'public/images' dan ambil nama file saja
            $file->storeAs('images', $fileName, 'public');
        }

        // Buat produk baru dengan menyimpan hanya nama file di database
        $product = Produk::create([
            'name' => $request->nama,
            'stock' => $request->stock,
            'image' => $fileName, // Simpan hanya nama file
            'desc' => $request->deskripsi,
            'harga' => $request->harga,
        ]);

        // Redirect ke halaman daftar produk dengan pesan sukses
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $produk = Produk::findOrFail($id);

        return view('admin.produk-edit', compact('produk'));
    }
    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, string $id)
    {

        $request->validate([
            'nama' => 'required|string|max:255',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240', // Maksimum 10MB
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
        ]);

        $produk = Produk::findOrFail($id);

        // Cek apakah ada gambar baru yang diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($produk->image) {
                Storage::disk('public')->delete('images/' . $produk->image);
            }

            // Simpan gambar baru dengan nama unik dan hanya simpan nama filenya
            $file = $request->file('image');
            $fileName = time() . '_' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('images', $fileName, 'public');
        } else {
            // Jika tidak ada gambar baru, gunakan gambar yang ada
            $fileName = $produk->image;
        }

        // Update data produk
        $produk->update([
            'name' => $request->nama,
            'stock' => $request->stock,
            'image' => $fileName, // Simpan hanya nama file, bukan path lengkapnya
            'desc' => $request->deskripsi,
            'harga' => $request->harga,
        ]);

        // Redirect ke halaman produk dengan pesan sukses
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Temukan produk berdasarkan ID
        $product = Produk::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($product->image) {
            // Menghapus file gambar dari direktori 'public/images'

            Storage::disk('public')->delete('images/' . $product->image);
        }

        // Hapus produk dari database
        $product->delete();

        // Redirect ke halaman index produk dengan pesan sukses
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
