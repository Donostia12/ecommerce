@extends('home.header')
@section('content')
    <div style="margin-top: 100px"></div>
    <div class="container my-4">
        <div class="row">
            <!-- Left Section: Image and Thumbnails -->
            <div class="col-md-4">
                <div class="card">

                    <img src="{{ asset('storage/images/' . $data->image) }}" class="card-img-top img-fluid" alt="Product Image"
                        style="border-radius: 8px;">
                </div>

            </div>

            <!-- Middle Section: Product Details -->
            <div class="col-md-5">
                <h3 class="font-weight-bold text-primary">{{ $data->name }}</h3>
                {{-- <p><i class="fas fa-shopping-bag"></i> Terjual 1 </p> --}}
                <h2 class="text-danger">Rp{{ number_format($data->harga, 0, ',', '.') }}</h2>
                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail"
                            type="button" role="tab" aria-controls="detail" aria-selected="true">Detail</button>
                    </li>
                </ul>
                <div class="tab-content mt-2" id="myTabContent">
                    <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                        {!! $data->desc !!}

                    </div>

                </div>
            </div>

            <!-- Right Section: Purchase Options -->
            <!-- Right Section: Purchase Options -->
            <div class="col-md-3">
                <form method="POST" action="{{ route('transaksi.store') }}" onsubmit="return confirmCheckout()">
                    @csrf

                    <div class="card p-3">
                        <h6>Atur jumlah dan catatan</h6>
                        <!-- Hidden fields for product ID and user ID -->
                        <input type="text" name="id_produk" value="{{ $data->id }}" hidden>

                        @if (Auth::user())
                            <input type="text" name="penerima" value="{{ Auth::user()->name }}" hidden>
                            <input type="text" name="id_user" value="{{ Auth::user()->id }}" hidden>
                        @else
                            <p class="text text-danger">Silahkan Login Terlebih Dahulu</p>
                        @endif

                        <!-- Quantity controls -->
                        <div class="d-flex align-items-center mb-3">
                            <button type="button" class="btn btn-outline-secondary me-2"
                                onclick="decreaseQuantity()">-</button>
                            <input type="text" class="form-control text-center" id="quantityInput" name="amount"
                                value="1" style="width: 50px;" readonly>
                            <button type="button" class="btn btn-outline-secondary ms-2"
                                onclick="increaseQuantity()">+</button>
                        </div>

                        <p>Stok Total: <span class="text-danger">{{ $data->stock }}</span></p>
                        <h5>Subtotal</h5>
                        <h4 class="text-danger" id="subtotal">Rp{{ number_format($data->harga, 0, ',', '.') }}</h4>
                        <input type="text" id="totalInput" name="total" value="{{ $data->harga }}" hidden>
                        <!-- Submit button for adding to cart -->
                        <button type="submit" class="btn btn-success w-100 mb-2"
                            @if (!Auth::user()) disabled @endif>+ Keranjang</button>
                    </div>

                </form>
            </div>

            <script>
                const maxStock = {{ $data->stock }};
                const price = {{ $data->harga }};
                const subtotalElement = document.getElementById('subtotal');
                const totalInput = document.getElementById('totalInput');

                function updateSubtotal(quantity) {
                    const subtotal = quantity * price;
                    subtotalElement.textContent = `Rp${subtotal.toLocaleString('id-ID')}`;
                    totalInput.value = subtotal; // Update hidden total input for form submission
                }

                function increaseQuantity() {
                    const quantityInput = document.getElementById('quantityInput');
                    let quantity = parseInt(quantityInput.value);
                    if (quantity < maxStock) {
                        quantityInput.value = quantity + 1;
                        updateSubtotal(quantity + 1);
                    }
                }

                function decreaseQuantity() {
                    const quantityInput = document.getElementById('quantityInput');
                    let quantity = parseInt(quantityInput.value);
                    if (quantity > 1) {
                        quantityInput.value = quantity - 1;
                        updateSubtotal(quantity - 1);
                    }
                }

                function confirmCheckout() {
                    return confirm("Apakah Anda yakin ingin melanjutkan ke proses checkout?");
                }
            </script>

        </div>
    </div>
@endsection
