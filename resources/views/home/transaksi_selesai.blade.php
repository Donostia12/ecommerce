@extends('home.header')
@section('content')
    <div style="margin-top: 100px"></div>
    <div id="floating-button" class="btn btn-danger position-fixed bottom-0 end-0 m-4 d-none" onclick="printSelected()">
        Cetak
    </div>
    @foreach ($transaksi as $data)
        <div class="container my-5">
            <div class="card shadow-sm p-4">
                <div class="row g-3 align-items-center">


                    <!-- Product Image Section -->
                    <div class="col-12 col-md-4 text-center">
                        <img src="{{ asset('storage/images/' . $data['image']) }}" class="img-fluid rounded"
                            alt="Product Image">
                    </div>

                    <!-- Product Details Section -->
                    <div class="col-12 col-md-7">
                        <h4 class="text-primary font-weight-bold">{{ $data['produk'] }}</h4>
                        <p class="text-muted mb-3">Harga Satuan: Rp{{ number_format($data['harga'], 0, ',', '.') }}</p>

                        <!-- Amount & Total Price -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                            <span><strong>Jumlah yang Dibeli:</strong> {{ $data['amount'] }}</span>
                            <span class="text-danger font-weight-bold">Total:
                                Rp{{ number_format($data['total'], 0, ',', '.') }}</span>
                        </div>

                        <!-- Status -->
                        @if ($data['status'] == 3)
                            <h4 class="text-danger font-weight-bold">Status :
                                <span class="text-danger font-weight-bold">Belum di bayar</span>
                            @elseif ($data['status'] == 2)
                                <h4 class="text-warning font-weight-bold">Status :
                                    <span class="text-warning font-weight-bold">Menuggu Diprosess Admin</span>
                                @elseif ($data['status'] == 1)
                                    <h4 class="text-success font-weight-bold">Status :
                                        <span class="text-success font-weight-bold">Pesanan Selesai</span>
                        @endif
                        </h4>

                        <!-- Recipient Information -->
                        <hr>
                        <h6 class="font-weight-bold">Informasi Penerima</h6>
                        <p><strong>Nama Penerima:</strong> {{ $data['penerima'] }}</p>
                        <p><strong>Alamat:</strong> {{ $data['alamat'] ?: 'Belum Terisi' }}</p>
                        <p><strong>Nomor Telepon:</strong> {{ $data['telp'] ?: 'Belum Terisi' }}</p>

                        <!-- Edit Button -->
                        @if ($data['status'] != 1)
                            <button type="button" class="btn btn-primary edit-button" data-id="{{ $data['id'] }}"
                                data-bs-toggle="modal" data-bs-target="#editModal{{ $data['id'] }}">
                                Edit Transaksi
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editModal{{ $data['id'] }}" tabindex="-1" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('transaksi.update', $data['id']) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Alamat -->
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat"
                                    value="{{ $data['alamat'] }}" required>
                            </div>

                            <!-- Nomor Telepon -->
                            <div class="mb-3">
                                <label for="telp" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="telp" name="telp"
                                    value="{{ $data['telp'] }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="telp" class="form-label">Deskripsi</label>
                                <input type="text" class="form-control" id="desc" name="desc"
                                    value="{{ $data['desc'] }}" required>
                            </div>
                            <!-- Jenis Bank -->

                            <div class="mb-3">
                                <label for="bank" class="form-label">Jenis Bank</label>
                                <select class="form-select" id="bank" name="bank" required>
                                    <option selected disabled>Pilih Bank</option>
                                    <option value="BRI">BRI</option>
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="BNI">BNI</option>
                                    <option value="BCA">BCA</option>
                                </select>
                            </div>

                            <!-- Bukti Pembayaran -->
                            <div class="mb-3">
                                <label for="bukti_pembayaran" class="form-label">Upload Bukti Pembayaran</label>
                                <input type="file" class="form-control" id="bukti_pembayaran" name="image">
                            </div>
                            <div class="col-12 col-md-4 text-center">
                                <img src="{{ asset('storage/images/' . $data['bukti']) }}" class="img-fluid rounded"
                                    alt="Product Image">
                            </div>

                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
    <!-- Modal Structure -->
@endsection
