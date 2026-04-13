<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                {{ config('app.name', 'Laravel') }}
            </a>

            <div class="d-flex gap-2">
                @auth
                    <a href="{{ route('home') }}" class="btn {{ request()->routeIs('home') ? 'btn-primary' : 'btn-outline-primary' }}">Beranda</a>
                    <a href="{{ route('transaksi') }}" class="btn {{ request()->routeIs('transaksi') ? 'btn-primary' : 'btn-outline-primary' }}">Transaksi</a>
                    <a href="{{ route('produk') }}" class="btn {{ request()->routeIs('produk') ? 'btn-primary' : 'btn-outline-primary' }}">Produk</a>
                    <a href="{{ route('user') }}" class="btn {{ request()->routeIs('user') ? 'btn-primary' : 'btn-outline-primary' }}">User</a>
                    <a href="{{ route('laporan') }}" class="btn {{ request()->routeIs('laporan') ? 'btn-primary' : 'btn-outline-primary' }}">Laporan</a>
                @endauth
            </div>

            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="btn btn-outline-success me-2" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-secondary" href="{{ route('register') }}">Register</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="btn btn-outline-dark dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest   
            </ul>
        </div>
    </nav>

    <main class="py-4 container">
        {{ $slot }} 
    </main>
</div>
</body>
</html>