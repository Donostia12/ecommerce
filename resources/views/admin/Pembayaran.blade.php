@extends('admin.header')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Table Pembayaran yang menunggu di konfirmasi</h6>
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
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Bank</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['nama_produk'] }}</td>
                                <td>{{ $item['amount'] }}</td>

                                <td>Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                                <td>{{ $item['status'] == 3 ? 'Belum Dibayar' : 'Menunggu Konfirmasi' }}</td>
                                <td>{{ $item['bank'] }}</td>
                                <td><img src="{{ asset('storage/images/' . $item['image']) }}" alt="Product Image"
                                        width="50"></td>
                                <td class="text-center">
                                    @if ($item['combo'])
                                        <button class="btn btn-warning btn-sm"
                                            onclick="openModal('viewModal{{ $loop->index }}')" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-primary btn-sm"
                                            onclick="openModal('viewModal{{ $loop->index }}')" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal Structure -->
                            <div class="modal fade" id="viewModal{{ $loop->index }}" tabindex="-1"
                                aria-labelledby="viewModalLabel{{ $loop->index }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewModalLabel{{ $loop->index }}">Detail
                                                Pembayaran</h5>
                                            <button type="button" class="btn-close"
                                                onclick="closeModal('viewModal{{ $loop->index }}')"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="list-group">
                                                <li class="list-group-item"><strong>Nama Produk:</strong>
                                                    {{ $item['nama_produk'] }}</li>
                                                <li class="list-group-item"><strong>Pesan Pembeli:</strong>
                                                    {{ $item['desc'] }}</li>
                                                <li class="list-group-item"><strong>Harga:</strong>
                                                    Rp{{ number_format($item['harga'], 0, ',', '.') }}</li>
                                                <li class="list-group-item"><strong>Jumlah:</strong> {{ $item['amount'] }}
                                                </li>
                                                <li class="list-group-item"><strong>Bank:</strong> {{ $item['bank'] }}</li>
                                                <li class="list-group-item text-center">
                                                    <strong>Bukti Pembayaran:</strong><br>
                                                    <img src="{{ asset('storage/images/' . $item['image']) }}"
                                                        alt="Bukti Pembayaran" class="img-fluid" style="max-width: 100px;">
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">

                                            @if ($item['combo'])
                                                <form method="POST" action="{{ route('transaksi.accept.combo') }}">
                                                    @csrf
                                                    <input type="text" name="id_transaksi" value="{{ $item['combo'] }}"
                                                        hidden>
                                                    <button type="button" class="btn btn-secondary"
                                                        onclick="closeModal('viewModal{{ $loop->index }}')">Tutup</button>
                                                    <button type="submit" class="btn btn-success">Terima Combo</button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('transaksi.accept', $item['id']) }}">
                                                    @csrf
                                                    <button type="button" class="btn btn-secondary"
                                                        onclick="closeModal('viewModal{{ $loop->index }}')">Tutup</button>
                                                    <button type="submit" class="btn btn-success">Terima</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
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
