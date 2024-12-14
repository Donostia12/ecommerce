@extends('admin.header')
@section('content')
    <!-- DataTales Example -->


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Table Produk Asih Konvenksi</h6>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Pembeli</th>
                            <th>jumlah</th>
                            <th>Status</th>
                            <th>Tanggal Transaksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['pembeli'] }}</td>
                                <td>{{ $item['jumlah'] }}</td>
                                <td>{{ $item['status'] }}</td>
                                <td>{{ $item['tgltransaksi'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

    <script>
        $('#myTable').DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "Tidak ada data yang tersedia di tabel",
                "info": " Menampilkan _START_ Sampai _END_ dari _TOTAL_ Total",
                "infoEmpty": "0 : 0 dari 0 total",
                "infoFiltered": "(difilter dari _MAX_ total entri)",
                "lengthMenu": "Tampilkan _MENU_ Data",
                "loadingRecords": "Memuat...",
                "processing": "Memproses...",
                "search": "Cari:",
                "zeroRecords": "Tidak ada catatan yang cocok ditemukan",

            }
        });
    </script>
@endsection
