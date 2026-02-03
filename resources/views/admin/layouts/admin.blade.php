<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .sidebar {
            background: linear-gradient(180deg, #1e3a5f 0%, #0d253f 100%);
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: #fff;
        }
        .sidebar .nav-link i {
            width: 24px;
        }
        .navbar-brand-wrapper {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .content-wrapper {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .stat-card {
            border: none;
            border-radius: 12px;
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .badge-pending { background-color: #ffc107; color: #000; }
        .badge-confirmed { background-color: #198754; }
        .badge-canceled { background-color: #dc3545; }
    </style>
    @stack('styles')
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-2 sidebar p-0">
            <div class="navbar-brand-wrapper text-center">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none">
                    <i class="bi bi-hospital fs-3 d-block mb-2"></i>
                    <span class="fw-bold">Cabinet Dentaire</span>
                </a>
            </div>

            <nav class="px-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2 me-2"></i>Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}"
                           href="{{ route('admin.appointments.index') }}">
                            <i class="bi bi-calendar-check me-2"></i>Rendez-vous
                            @php
                                $pendingCount = \App\Models\Appointment::where('status', 'pending')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="badge bg-warning text-dark ms-auto">{{ $pendingCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.patients.*') ? 'active' : '' }}"
                           href="{{ route('admin.patients.index') }}">
                            <i class="bi bi-people me-2"></i>Patients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}"
                           href="{{ route('admin.services.index') }}">
                            <i class="bi bi-gear me-2"></i>Services
                        </a>
                    </li>
                </ul>

                <hr class="border-secondary my-4">

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}" target="_blank">
                            <i class="bi bi-box-arrow-up-right me-2"></i>Voir le site
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                <i class="bi bi-box-arrow-left me-2"></i>Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="col-md-10 content-wrapper p-0">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-3">
                <div class="container-fluid">
                    <h5 class="mb-0">@yield('page-title', 'Tableau de bord')</h5>
                    <div class="d-flex align-items-center">
                        <span class="me-3 text-muted">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ Auth::user()->name }}
                        </span>
                        <span class="badge bg-primary">Admin</span>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
