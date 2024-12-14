@extends('home.header')

@section('content')
    <!-- Slideshow -->



    <div id="eventCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active position-relative">
                <img src="{{ asset('image/baju wanita.png') }}" class="carousel-img mx-auto d-block" alt="Event 1"
                    style="background-color: #C459F5;">
                <!-- Overlay text -->
                <div class="position-absolute top-50 translate-middle-y text-white" style="margin-left: 20%;">
                    <h3>Temui Refrensi </h3>
                    <h3>Baju Wanita</h1>
                        <p> Baju Berkuliatas</p>
                </div>
            </div>
            <div class="carousel-item position-relative">
                <img src="{{ asset('image/rok.png') }}" class="carousel-img mx-auto d-block" alt="Event 2"
                    style="background-color: #59f57d;">
                <!-- Overlay text -->
                <div class="position-absolute top-50 translate-middle-y text-white" style="margin-left: 20%;">
                    <h3>Utamakan Katahanan</h3>
                    <h3>Rok Bahan </h1>
                        <p> top Bergaransi </p>
                </div>
            </div>
            <div class="carousel-item position-relative">
                <img src="{{ asset('image/baju.png') }}" class="carousel-img mx-auto d-block" alt="Event 3"
                    style="background-color: #1e7ddc;">
                <!-- Overlay text -->
                <div class="position-absolute top-50 translate-middle-y text-white" style="margin-left: 20%;">
                    <h3>Baju Kasual </h3>
                    <h3>Minimalis</h3>
                    <p>Terendi.</p>
                </div>
            </div>
            <div class="carousel-item position-relative">
                <img src="{{ asset('image/kemeja.png') }}" class="carousel-img mx-auto d-block" alt="Event 3"
                    style="background-color: #87dc1e;">
                <!-- Overlay text -->
                <div class="position-absolute top-50 translate-middle-y text-white" style="margin-left: 20%;">
                    <h3>Formal kikinian </h3>
                    <h3>Kualitas</h3>
                    <p>Papan Atas</p>
                </div>
            </div>
            <div class="carousel-item position-relative">
                <img src="{{ asset('image/Celana.png') }}" class="carousel-img mx-auto d-block" alt="Event 3"
                    style="background-color: #e9b310;">
                <!-- Overlay text -->
                <div class="position-absolute top-50 translate-middle-y text-white" style="margin-left: 20%;">
                    <h3>Celanan Formal </h3>
                    <h3>Tahan Lama</h3>
                    <p>Bergaransi</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            <span class="display-4 text-success"id="slide">&lt;</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            <span class="display-4 text-success" id="slide">&gt;</span>
        </button>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="flashMessageModal" tabindex="-1" aria-labelledby="flashMessageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="flashMessageModalLabel">Pesan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Pesan Flash -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @if (session('success') || $errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var flashMessageModal = new bootstrap.Modal(document.getElementById('flashMessageModal'), {
                    keyboard: false
                });
                flashMessageModal.show();
            });
        </script>
    @endif



    <!-- Flash Sale and Product List -->
    <div class="container my-4">
        <div class="row">
            <!-- Left Flash Sale Banner -->
            <div class="col-12 col-md-3 mb-4" id="Terbaru">
                <div class="bg-success text-white text-center py-4 rounded">
                    <h5>Terbaru</h5>
                    <p>Silahkan Order disini</p>
                    <button class="btn btn-light">Asih Konveksi</button>
                </div>
            </div>

            <!-- Product List -->
            <div class="col-12 col-md-9">
                <div class="d-flex overflow-auto px-2" style="white-space: nowrap;">
                    <!-- Product Card Start -->

                    @foreach ($recomment as $item)
                        @if ($item->stock > 0)
                            <!-- Kondisi untuk menampilkan produk jika stok lebih dari 0 -->
                            <div class="col-6 col-md-4 mb-4" style="display: inline-block; width: 25%; padding: 0 10px;">
                                <a href="{{ route('produk-detail', $item->id) }}" class="text-decoration-none text-dark">
                                    <div class="card shadow-sm border-0">
                                        <img src="{{ asset('storage/images/' . $item->image) }}"
                                            class="card-img-top product-img" alt="Product Image">
                                        <div class="card-body text-center">
                                            <h6 class="card-title font-weight-bold text-primary">{{ $item->name }}</h6>
                                            <p class="card-text text-dark">
                                                Rp{{ number_format($item->harga, 0, ',', '.') }}
                                            </p>
                                            <div class="progress mb-3" style="height: 10px;">
                                                <div class="progress-bar 
                                            @if ($item->stock < 5) bg-danger
                                            @elseif($item->stock <= 10) bg-warning
                                            @else bg-info @endif"
                                                    role="progressbar"
                                                    style="width: {{ min(100, ($item->stock / 15) * 100) }}%"
                                                    aria-valuenow="{{ $item->stock }}" aria-valuemin="0"
                                                    aria-valuemax="15">
                                                </div>
                                            </div>
                                            <p class="text-muted small">Stok: {{ $item->stock }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach

                    <!-- Add more cards as needed -->
                </div>
            </div>
        </div>
    </div>


    <!-- Recommendations Section -->
    <div class="container my-4">
        <h5>Produk Terbaru </h5>
        <p>Silahkan Temukan Produk Anda Disini :</p>
        <div class="row">
            @foreach ($data as $item)
                @if ($item->stock > 0)
                    <!-- Kondisi untuk menampilkan produk jika stok lebih dari 0 -->
                    <div class="col-6 col-md-2 mb-3">
                        <a href="{{ route('produk-detail', $item->id) }}" class="text-decoration-none text-dark">
                            <div class="card text-center">
                                <img src="{{ asset('storage/images/' . $item->image) }}"
                                    class="card-img-top recommendation-img" alt="Recommendation Image">
                                <div class="card-body">
                                    <p class="card-text">{{ $item->name }}</p>
                                    <p class="card-text text-dark">Rp{{ number_format($item->harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
