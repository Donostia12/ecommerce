@extends('home.header')
@section('content')
    <div style="margin-top: 100px"></div>
    <div id="floating-button" class="btn btn-danger position-fixed bottom-0 end-0 m-4 d-none" onclick="printSelected()">
        Cetak
    </div>
    @if (count($transaksi) == 0)
        <div class="container text-center my-5">
            <h4>Anda belum melakukan pesanan</h4>
        </div>
    @endif
    <style>
        .select-transaction {
            transform: scale(1.5);
        }
    </style>
    @foreach ($transaksi as $data)
        <div class="container my-5">
            <div class="card shadow-sm p-4">
                <div class="row g-3 align-items-center">
                    <!-- Checkbox -->
                    <div class="col-1 d-flex justify-content-center align-items-center">
                        <input type="checkbox" class="form-check-input select-transaction" data-id="{{ $data['id'] }}"
                            onclick="handleCheckbox(this)" {{ $data['status'] == 2 ? 'disabled' : '' }}>
                    </div>


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
                                <label for="telp" class="form-label">Deskripsi (ukuran , atau request dll) "</label>
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
    <!-- Tombol Cetak -->
    <button id="cetakButton" class="btn btn-success"
        style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 1000; font-size: 18px; padding: 10px 20px;"
        onclick="openCetakModal()">Bayar</button>

    <!-- Modal Structure -->
    <div class="modal fade" id="cetakModal" tabindex="-1" aria-labelledby="cetakModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="cetakForm" method="POST" action="{{ route('combo_transaksi') }}"
                    enctype="multipart/form-data">
                    @csrf <!-- Token CSRF untuk keamanan -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="cetakModalLabel">Cetak Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <input type="text" name="id_transaksi" id="id_transaksi" required hidden>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="telp" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="telp" name="telp" required>
                        </div>
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

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Total Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Upload Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        let selectedItems = new Set();
        let totalHarga = 0;

        document.addEventListener('DOMContentLoaded', () => {
            const cetakButton = document.getElementById('cetakButton');
            const editButtons = document.querySelectorAll('.edit-button');

            if (cetakButton) {
                cetakButton.classList.add('d-none'); // Ensure button is hidden initially
            }
            if (editButtons) {
                editButtons.forEach(button => button.style.display = 'block'); // Ensure edit buttons are visible
            }
        });

        function handleCheckbox(checkbox) {
            const id = checkbox.dataset.id;

            if (checkbox.checked) {
                selectedItems.add(id);
                updateTotalHarga(id, true); // Add item price
            } else {
                selectedItems.delete(id);
                updateTotalHarga(id, false); // Subtract item price
            }

            updateIdTransaksi();
            toggleButtons();
        }

        function updateTotalHarga(id, isAdding) {
            fetch(`http://localhost:8000/api/ajax_transaksi/${id}`)
                .then(response => {
                    if (!response.ok) throw new Error(`Failed to fetch data for ID ${id}`);
                    return response.json();
                })
                .then(data => {
                    totalHarga = isAdding ? totalHarga + data.total : totalHarga - data.total;
                    updateHargaInModal();
                })
                .catch(error => console.error(`Error fetching data for ID ${id}:`, error));
        }

        /**
         * Update the total price displayed in the modal.
         */
        function updateHargaInModal() {
            const hargaInput = document.getElementById('harga');
            if (hargaInput) {
                hargaInput.value = totalHarga.toLocaleString('id-ID');
            } else {
                console.warn("Element with ID 'harga' not found.");
            }
        }

        /**
         * Update the ID transaksi displayed in the input field.
         */
        function updateIdTransaksi() {
            const idTransaksiInput = document.getElementById('id_transaksi');
            if (idTransaksiInput) {
                idTransaksiInput.value = Array.from(selectedItems).join(',');
            } else {
                console.warn("Element with ID 'id_transaksi' not found.");
            }
        }

        /**
         * Toggle visibility of buttons based on selection.
         */
        function toggleButtons() {
            const cetakButton = document.getElementById('cetakButton');
            if (cetakButton) {
                cetakButton.classList.toggle('d-none', selectedItems.size === 0);
            }
        }


        /**
         * Toggle visibility of buttons based on the selection.
         */
        function toggleButtons() {
            const cetakButton = document.getElementById('cetakButton');
            const editButtons = document.querySelectorAll('.edit-button');

            if (cetakButton) {
                if (selectedItems.size > 0) {
                    cetakButton.classList.remove('d-none');
                    editButtons.forEach(button => button.style.display = 'none');
                } else {
                    cetakButton.classList.add('d-none');
                    editButtons.forEach(button => button.style.display = 'block');
                }
            } else {
                console.warn("Element with ID 'cetakButton' not found.");
            }
        }

        /**
         * Open the modal for printing selected items.
         */
        function openCetakModal() {
            if (selectedItems.size > 0) {
                const modalElement = document.getElementById('cetakModal');
                if (modalElement) {
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show();
                } else {
                    console.warn("Element with ID 'cetakModal' not found.");
                }
            } else {
                alert('Pilih setidaknya satu item untuk melanjutkan.');
            }
        }
    </script>
@endsection
