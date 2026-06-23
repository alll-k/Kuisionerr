<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UNIMUS EduConnect')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6c63ff;
            --secondary-color: #f093fb;
            --danger-color: #ff6b6b;
            --success-color: #51cf66;
            --warning-color: #ffd93d;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        
        .sidebar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,.05);
            min-height: calc(100vh - 56px);
        }
        
        .sidebar .nav-link {
            color: #333;
            border-left: 3px solid transparent;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #f0f0f0;
            border-left-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            border-radius: 8px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #5a52d5;
            border-color: #5a52d5;
        }
        
        .badge {
            padding: 5px 10px;
            font-size: 0.85rem;
        }
    </style>
    @yield('styles')
</head>
<body>
    @auth
        <nav class="navbar navbar-dark sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="/dashboard">
                    <i class="fas fa-graduation-cap"></i> UNIMUS EduConnect
                </a>
                <div class="dropdown">
                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-user"></i> Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container-fluid">
            <div class="row">
                @if (Auth::user()->role->name === 'admin')
                    <nav class="col-md-2 sidebar p-3">
                        <div class="nav flex-column">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.questionnaires.*') ? 'active' : '' }}" href="{{ route('admin.questionnaires.index') }}">
                                <i class="fas fa-list"></i> Kuesioner
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}" href="{{ route('admin.analytics') }}">
                                <i class="fas fa-chart-bar"></i> Analitik
                            </a>
                        </div>
                    </nav>
                    <main class="col-md-10 ms-sm-auto px-md-4 py-4">
                @else
                    <main class="col-12 px-md-4 py-4">
                @endif
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @yield('content')
                </main>
            </div>
        </div>
    @else
        @yield('content')
    @endauth
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    @yield('scripts')
</body>
</html>
