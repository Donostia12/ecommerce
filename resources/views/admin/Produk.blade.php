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

        <a href="{{ route('produk.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Stok Produk</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->stock }}</td>
                                <td>{!! Str::limit($item->desc, 50) !!}</td>
                                <td>{{ $item->harga }}</td>
                                <td><img src="{{ asset('storage/images/' . $item->image) }}" alt="Product Image"
                                        width="50"></td>
                                <td class="text-center">
                                    <a href="{{ route('produk.edit', $item->id) }}" class="btn btn-warning btn-sm"
                                        title="Update">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if ($item->status == 2)
                                        <a href="{{ route('produk.status', [$item->id, 1]) }}" class="btn btn-danger btn-sm"
                                            title="Status 2">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </a>
                                    @elseif ($item->status == 1)
                                        <a href="{{ route('produk.status', [$item->id, 2]) }}"
                                            class="btn btn-success btn-sm" title="Status 1">
                                            <i class="fas fa-check-circle"></i>
                                        </a>
                                    @endif
                                </td>
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
