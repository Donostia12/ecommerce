@extends('home.header')

@section('content')
    <div class="container" style="margin-top: 250px;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center">Ubah Password Baru</h2>

                        <!-- Penangkap Session -->
                        <div id="session-messages">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                        </div>

                        <!-- Form Lupa Password -->
                        <form action="{{ route('reset.password.user', request()->route('id')) }}" method="POST"
                            id="forgot-password-form">
                            @csrf
                            <div class="mb-3">
                                <label for="Password" class="form-label">Password Baru</label>
                                <input type="text" class="form-control" id="password" name="password"
                                    placeholder="Masukkan Password" required>
                                <label for="Password" class="form-label">Konfirmasi Password Baru</label>
                                <input type="text" class="form-control" id="password1" name="password1"
                                    placeholder="Masukkan Verifikasi Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
