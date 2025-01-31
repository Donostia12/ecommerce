<?php

namespace App\Http\Controllers;

use App\Models\pembayaran;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [];

        // Ambil semua pembayaran
        $pembayaran = pembayaran::all();

        foreach ($pembayaran as $item) {
            // Cari transaksi yang memiliki status 2 sesuai dengan id_transaksi dari pembayaran
            $transaksi = Transaksi::where('id', $item->id_transaksi)->where('status', '2')->first();

            if ($transaksi) {
                // Cari produk sesuai dengan id_produk di transaksi
                $produk = Produk::where('id', $transaksi->id_produk)->first();

                if ($produk) {
                    // Jika pembayaran memiliki combo
                    if ($item->combo) {
                        $comboitem = explode(',', $item->combo);

                        // Inisialisasi ulang variabel untuk combo
                        $transaksi_amout = [];
                        $transaksi_item_name = [];
                        $transaksi_total_harga = [];

                        foreach ($comboitem as $item1) {
                            $transaksi1 = Transaksi::where('id', $item1)->where('status', '2')->first();

                            if ($transaksi1) {
                                $transaksi_amout[] = $transaksi1->amount;

                                $name = Produk::where('id', $transaksi1->id_produk)->first();
                                if ($name) {
                                    $transaksi_item_name[] = $name->name;
                                }

                                $transaksi_total_harga[] = $transaksi1->total;
                            }
                        }

                        // Gabungkan nilai combo
                        $transaksi_amout_combined = implode(' + ', $transaksi_amout);
                        $transaksi_name_combined = implode(' + ', $transaksi_item_name);
                        $total_harga_semua = array_sum($transaksi_total_harga);

                        $data[] = [
                            'id' => $item->id_transaksi,
                            'nama_produk' => $transaksi_name_combined,
                            'amount' => $transaksi_amout_combined,
                            'pembeli' => $transaksi->penerima,
                            'alamat' => $transaksi->alamat,
                            'telp' => $transaksi->telp ?: "kosong",
                            'harga' => $total_harga_semua,
                            'status' => $transaksi->status,
                            'bank' => $item->bank,
                            'image' => $item->image,
                            'desc' => $item->desc,
                            'combo' => $item->combo
                        ];
                    } else {

                        // Jika bukan combo, masukkan data biasa
                        $data[] = [
                            'id' => $item->id_transaksi,
                            'nama_produk' => $produk->name,

                            'pembeli' => $transaksi->penerima,
                            'alamat' => $transaksi->alamat,
                            'telp' => $transaksi->telp ?: "kosong",
                            'amount' => $transaksi->amount,
                            'harga' => $produk->harga,
                            'status' => $transaksi->status,
                            'bank' => $item->bank,
                            'image' => $item->image,
                            'desc' => $item->desc,
                            'combo' => null
                        ];
                    }
                }
            }
        }

        return view('admin.Pembayaran', compact('data'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
