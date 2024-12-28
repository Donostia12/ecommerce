@extends('home.header')

@section('content')
    <div class="container" style="margin-top: 250px;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center">Lupa Password</h2>

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
                        <form action="{{ route('reset.password') }}" method="POST" id="forgot-password-form">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Masukkan email" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
