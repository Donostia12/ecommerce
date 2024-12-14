@extends('admin.header')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Table Penjualan</h6>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Terjual</th>
                            <th>Stock Tersisa</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['sold'] }}</td>
                                <td>{{ $item['stock'] }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script>
        $('#myTable').DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "Tidak ada data yang tersedia di tabel",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ total",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 total",
                "infoFiltered": "(difilter dari _MAX_ total entri)",
                "lengthMenu": "Tampilkan _MENU_ data",
                "loadingRecords": "Memuat...",
                "processing": "Memproses...",
                "search": "Cari:",
                "zeroRecords": "Tidak ada catatan yang cocok ditemukan",
            }
        });

        var modals = {};

        function openModal(modalId) {
            var modalElement = document.getElementById(modalId);
            modals[modalId] = new bootstrap.Modal(modalElement);
            modals[modalId].show();
        }

        function closeModal(modalId) {
            if (modals[modalId]) {
                modals[modalId].hide();
            }
        }
    </script>
@endsection
