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
    </style>
</head>

<body style="max-width: 100vw;overflow-x: hidden;">
    <nav class="navbar navbar-expand-sm navbar-dark" style="background: #00AEA6">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ url('img') . '/logo.png' }}" alt="alumni-trace" width="32" height="32" class="me-2">
            </a>
            <button class="navbar-toggler" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-sm-0">
                    <li class="nav-item">
                        <a class="nav-link @yield('dashboard')" href="#">Dashboard</a>
                    </li>
                    @if (Auth::user()->role == 'superAdmin')
                        <li class="nav-item">
                            <a class="nav-link @yield('account')" href="#">Kelola Akun</a>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'alumni')
                        <li class="nav-item">
                            <a class="nav-link @yield('gallery')" href="#">Galeri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield('forum')" href="#">Forum</a>
                        </li>
                    @endif
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link @yield('forum')" href="#">Forum</a>
                        </li>
                    @endif
                </ul>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" >
                        <img src="{{ url('img') . '/pp.png' }}" alt="" width="32" height="32" class="rounded-circle me-2">
                    </a>
                    <ul class="dropdown-menu text-small shadow  dropdown-menu-end">
                        <li><a class="dropdown-item" href="/profile">{{ Auth::user()->username }}</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/logout">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid mt-3 px-5">
        <h4 style="text-transform: capitalize;color:#00A9AD;font-weight: bold">@yield('page')</h4>
        @yield('content')
    </div>
</body>

</html>
