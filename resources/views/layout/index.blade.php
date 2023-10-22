<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <style>
        body {
            font-family: 'Montserrat';
        }
        @media (max-width: 768px) {
            .custom-dropdown {
                position: static;
                float: right;
            }
        }
    </style>
</head>

<body style="max-width: 100vw;overflow-x: hidden;">
    <nav class="navbar navbar-expand-sm navbar-dark py-3" style="background: #00AEA6">
        <div class="container-fluid">
            <a class="navbar-brand" href="/dashboard">
                <img src="{{ url('img/logo_white.png') }}" alt="alumni-trace" height="32" class="me-2">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navcontent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcontent">
                <ul class="navbar-nav me-auto mb-2 mb-sm-0">
                    <li class="nav-item">
                        <a class="nav-link @yield('dashboard')" href="/dashboard">Dashboard</a>
                    </li>
                    @if (Auth::user()->role == 'superAdmin')
                        <li class="nav-item">
                            <a class="nav-link @yield('account')" href="/kelola-akun">Kelola Akun</a>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'alumni')
                        <li class="nav-item">
                            <a class="nav-link @yield('gallery')" href="/galeri">Galeri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield('forum')" href="/forum">Forum</a>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link @yield('forum')" href="/forum">Forum</a>
                        </li>
                    @endif
                </ul>
                <div class="dropdown custom-dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown">
                        <img src="{{ $pfp ? url('img') . '/' . $pfp : url('img') . '/pp.png' }}" alt="" width="32" height="32"
                            class="rounded-circle me-2">
                    </a>
                    <ul class="dropdown-menu text-small shadow dropdown-menu-end">
                        <li><a class="dropdown-item" style="pointer-events: none"
                                href="#">{{ Auth::user()->username }}</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/profile/{{ Auth::user()->id_akun }}">Profile</a></li>
                        <li><a class="dropdown-item" href="/logout">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid mt-3 px-5">
        <div class="d-flex align-items-end" style="gap:10px">
            <h4 style="text-transform: capitalize;color:#00A9AD;font-weight: bold">@yield('page')</h4>
            <h6><a style="color:#00A9AD;text-decoration: underline" href="@yield('sublink')">@yield('subpage')</a></h6>
        </div>
        @include('layout.flash-massage')
        @yield('content')
    </div>
</body>

</html>
