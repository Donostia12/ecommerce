<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asih Konveksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid" style="background-color: #e0e2e5">
            <a class="navbar-brand" href="{{ route('index') }}">
                <img src="{{ asset('image/logo.png') }}" alt="Logo"
                    style="width: 100px; height: auto; object-fit: contain;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <form class="d-flex mx-auto w-75 my-2 my-lg-0" method="GET" action="{{ route('index.search') }}">
                    <input class="form-control me-2" type="search" placeholder="Cari di Asih Konveksi" name="query"
                        aria-label="Search" required>
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

                <ul class="navbar-nav ms-auto">

                    @if (Auth::user())
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('transaksi.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                <!-- Badge Notification -->
                                <span
                                    class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger"
                                    style="font-size: 0.75rem;">
                                    {{ $jumlahItem ?? 0 }}<!-- Ubah angka ini sesuai jumlah item atau notifikasi -->
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        </li>
                    @endif

                    @auth
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="profileDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->username }}
                            </a>

                            <!-- Profile Dropdown Menu -->
                            <ul class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="profileDropdown">
                                <li class="text-center mb-3">
                                    <img src="{{ asset(Auth::user()->profile_photo_url ?? 'image/default_profile.jpeg') }}"
                                        alt="Profile Photo" class="profile-photo">
                                    <h6>{{ Auth::user()->name }}</h6>
                                    <p class="text-muted mb-1">{{ Auth::user()->username }}</p>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('transaksi.index') }}">
                                        <i class="fas fa-shopping-cart"></i> Pembelian
                                    </a>
                                    <a class="dropdown-item" href="{{ route('transaksi.index.selesai') }}">

                                        <i class="fas fa-check-circle text-success"></i> riwayat
                                    </a>
                                    <a class="dropdown-item" href="{{ route('home.setting') }}">
                                        <i class="fas fa-cog"></i> Pengaturan
                                    </a>

                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="fas fa-user"></i> Account
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <style>
        /* Styling dropdown to be more like a profile card */


        /* Display dropdown on hover for desktop */
    </style>


    @yield('content')
    <!-- Login/Register Modal -->
    @extends('home.modal')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
