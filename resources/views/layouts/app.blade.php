<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CaseBuddy')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/app.css">
    <style>
        .navbar-nav {
            width: 100%;
        }
        @media (min-width: 992px) {
            .navbar-nav {
                justify-content: flex-end;
            }
        }
        @media (max-width: 991px) {
            .navbar-nav {
                justify-content: center;
                text-align: center;
            }
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        footer p {
            position: sticky;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            text-align: center;
            padding: 1rem 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}" style="width: 250px">
                <div class="d-flex flex align-items-center">
                    <img src="/logo.png" alt="Logo" style="height: 40px;margin-right: 7px">
                    <span style="color: #2c3e50;">CaseBuddy</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    @if(auth()->check() && auth()->user()->role !== 'admin' && auth()->user()->role !== 'subadmin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('complaints.create') }}">File a Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('complaints.index') }}">My Reports</a>
                        </li>
                    @endif
                    @auth
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('complaints.search') }}">Search Cases</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.complaints.index') }}">All Cases</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Create an Account</a>
                            </li>
                        @elseif(auth()->user()->role === 'subadmin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('complaints.search') }}">Search Cases</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.complaints.index') }}">Assigned Cases</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
