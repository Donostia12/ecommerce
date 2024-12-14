<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualan = Penjualan::all();
        $data = [];
        foreach ($penjualan as $item) {
            $produk = Produk::where('id', $item->id_produk)->first();
            $data[] =
                [
                    'name' => $produk->name,
                    'sold' => $item->sold,
                    'stock' => $produk->stock
                ];
        }
        return view('admin.Penjualan', compact('data'));
    }



    public function penjualanBulanan(Request $request)
    {

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $data = [];
        $totalPenjualan = 0;

        if ($bulan && $tahun) {
            $data = FacadesDB::table('penjualan')
                ->join('produk', 'penjualan.id_produk', '=', 'produk.id')
                ->select(
                    'penjualan.*',
                    'produk.name as nama_produk',
                    'produk.harga',
                    FacadesDB::raw('penjualan.sold * produk.harga as penjualan')
                )
                ->whereMonth('penjualan.created_at', $bulan)
                ->whereYear('penjualan.created_at', $tahun)
                ->orderBy('penjualan.sold', 'desc')
                ->get();

            $totalPenjualan = $data->sum('penjualan');
        }

        return view('admin.Penjualan-bulanan', compact('data', 'totalPenjualan', 'bulan', 'tahun'));
    }

    public function print_pdf(Request $request)
    {
        $bulan = $request->query('bulan');
        $bulanName = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'][$bulan]; // Get 'bulan' parameter
        $tahun = $request->query('tahun');

        $data = [];
        $totalPenjualan = 0;

        if ($bulan && $tahun) {
            $data = FacadesDB::table('penjualan')
                ->join('produk', 'penjualan.id_produk', '=', 'produk.id')
                ->select(
                    'penjualan.*',
                    'produk.name as nama_produk',
                    'produk.harga',
                    FacadesDB::raw('penjualan.sold * produk.harga as penjualan')
                )
                ->whereMonth('penjualan.created_at', $bulan)
                ->whereYear('penjualan.created_at', $tahun)
                ->orderBy('penjualan.sold', 'desc')
                ->get();

            $totalPenjualan = $data->sum('penjualan');
        }
        $pdf = PDF::loadView('admin.penjualan_bulanan_pdf', compact('data', 'totalPenjualan', 'bulanName', 'tahun'));
        return $pdf->download('penjualan_bulanan.pdf');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
