@extends('admin.header')
@section('content')
    <div class="container my-5">
        <div class="card shadow p-4">
            <h4 class="card-title mb-4">Edit Produk</h4>

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('produk.update', $produk->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Method untuk update -->

                <!-- Nama Produk -->
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" id="nama" name="nama"
                        placeholder="Masukkan nama produk" required value="{{ old('name', $produk->name) }}">
                    @error('nama')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Stock Produk -->
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" placeholder="Jumlah stock"
                        required value="{{ old('stock', $produk->stock) }}">
                    @error('stock')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image Produk -->
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Produk</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <small class="text-muted">File yang didukung: .jpg, .jpeg, .png</small>
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    @if ($produk->image)
                        <p class="mt-2">Gambar saat ini:</p>
                        <img src="{{ asset('storage/images/' . $produk->image) }}" alt="Gambar Produk" width="100">
                    @endif
                </div>

                <!-- Deskripsi Produk -->
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi produk">{{ $produk->desc }}</textarea>
                    @error('deskripsi')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Harga Produk -->
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga produk"
                        required value="{{ old('harga', $produk->harga) }}">
                    @error('harga')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">Update Produk</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- CKEditor 5 CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#deskripsi'))
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endsection
