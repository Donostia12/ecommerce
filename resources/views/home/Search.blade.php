@extends('home.header')

@section('content')
    <div class="container">
        <h1>Hasil Pencarian</h1>

        @if (isset($query))
            <p>Menampilkan hasil pencarian untuk: <strong>{{ $query }}</strong></p>
        @endif

        <div class="row">
            @if ($products->isEmpty())
                <p>Produk tidak ditemukan.</p>
            @else
                @foreach ($products as $item)
                    <div class="col-md-3 mb-4">
                        <a href="{{ route('produk-detail', $item->id) }}" class="text-decoration-none text-dark">
                            <div class="card h-100">
                                <img src="{{ asset('storage/images/' . $item->image) }}" class="card-img-top"
                                    alt="{{ $item->name }}" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title text-truncate">{{ $item->name }}</h5>
                                    <p class="card-text text-danger">Rp{{ number_format($item->harga, 0, ',', '.') }}</p>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <button class="btn btn-primary w-100">Beli Sekarang</button>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
