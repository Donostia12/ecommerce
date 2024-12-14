@extends('home.header')
@section('content')
    <div style="margin-top: 100px"></div>
    <div class="container profile-container my-5">
        <div class="card shadow-lg">
            <!-- Top Bar -->
            <div class="bg-success text-white py-3 px-4" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
                <h5 class="mb-0">Profil Saya</h5>
            </div>

            <!-- Card Content -->
            <div class="p-4">
                <div class="row">
                    <!-- Left section: Profile picture and file upload -->
                    <div class="col-md-4 text-center">
                        <!-- Menampilkan Pesan Sukses atau Error -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card p-3 mb-3 border-0 shadow-sm">
                            <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                <img src="{{ asset('image/default_profile.jpeg') }}" alt="Profile Photo"
                                    class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                        </div>

                        <div class="card p-3 mt-4 border-0 shadow-sm">
                            <h6 class="text-center mb-3">Ubah Kata Sandi</h6>
                            <form action="{{ route('home.gantipass') }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <input type="password" name="sandilama" class="form-control"
                                        placeholder="Kata Sandi Lama">
                                </div>
                                <div class="mb-2">
                                    <input type="password" name="sandibaru" class="form-control"
                                        placeholder="Kata Sandi Baru">
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="sandivalid" class="form-control"
                                        placeholder="Konfirmasi Kata Sandi">
                                </div>
                                <button type="submit" class="btn btn-outline-primary w-100">Ubah Kata Sandi</button>
                            </form>
                        </div>
                    </div>

                    <!-- Right section: Profile information -->
                    <div class="col-md-8">
                        <h5 class="mb-3">Biodata Diri</h5>
                        <form action="#" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control"
                                    value="{{ Auth::user()->username }}" readonly>
                            </div>

                            <h5 class="mt-4 mb-3">Kontak</h5>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}"
                                    readonly>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
