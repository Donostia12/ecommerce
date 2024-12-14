@extends('admin.header')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Penjualan Bulanan</h6>
        </div>

        {{-- Form untuk memilih bulan dan tahun --}}
        <form method="GET" action="{{ route('penjualan.bulanan') }}" class="mb-3">
            <div class="form-group row">
                <div class="col-sm-1"></div>
                <label for="bulan" class="col-sm-2 col-form-label">Pilih Bulan dan Tahun</label>
                <div class="col-sm-3">
                    <select name="bulan" id="bulan" class="form-control" required>
                        <option value="" disabled selected>Pilih Bulan</option>
                        @foreach (range(1, 12) as $i)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="number" name="tahun" id="tahun" class="form-control" placeholder="Masukkan Tahun"
                        min="2000" max="{{ now()->year }}" value="{{ request('tahun') }}" required>
                </div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
        <div class="text-right mb-3">
            <a href="{{ route('penjualan.pdf') }}" class="btn btn-success" id="print_pdf">Print to PDF</a>
        </div>

        <script>
            // Fungsi untuk mendapatkan parameter dari URL
            function getUrlParams(url) {
                let params = {};
                let parser = new URL(url);
                for (let [key, value] of parser.searchParams.entries()) {
                    params[key] = value;
                }
                return params;
            }

            // Ambil URL saat ini
            const currentUrl = window.location.href;

            // Ambil parameter bulan dan tahun
            const params = getUrlParams(currentUrl);
            const bulan = params.bulan;
            const tahun = params.tahun;

            // Tambahkan parameter ke tautan Print to PDF jika ada
            const printPdfLink = document.getElementById('print_pdf');
            if (bulan && tahun) {
                printPdfLink.href += `?bulan=${bulan}&tahun=${tahun}`;
            }
        </script>

        {{-- Tabel untuk menampilkan data --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Harga (Rp)</th>
                            <th>Jumlah Terjual</th>
                            <th>Penjualan (Rp)</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td>{{ $item->sold }}</td>
                                <td>{{ number_format($item->penjualan, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('Y-m-d') }}</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data penjualan untuk bulan dan tahun yang
                                    dipilih</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">Total Penjualan (Rp)</th>
                            <th colspan="2">{{ number_format($totalPenjualan, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
