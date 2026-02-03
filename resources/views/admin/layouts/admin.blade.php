<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        body {
            background: #f5f7fa;
        }

        /* Modern Sidebar */
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
            position: fixed;
            width: 260px;
            z-index: 1000;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.85);
            padding: 14px 24px;
            border-radius: 12px;
            margin: 4px 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            font-size: 15px;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #fff;
            transform: translateX(-4px);
            transition: transform 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
            transform: translateX(4px);
        }

        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.25);
            color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .sidebar .nav-link.active::before {
            transform: translateX(0);
        }

        .sidebar .nav-link i {
            width: 24px;
            font-size: 18px;
        }

        .navbar-brand-wrapper {
            padding: 32px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            margin-bottom: 24px;
            background: rgba(0,0,0,0.1);
        }

        .navbar-brand-wrapper .bi-hospital {
            background: rgba(255,255,255,0.2);
            padding: 16px;
            border-radius: 16px;
            display: inline-block;
        }

        /* Content Wrapper */
        .content-wrapper {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            margin-left: 260px;
        }

        /* Top Navbar */
        .top-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .top-navbar h5 {
            font-weight: 700;
            color: #1f2937;
            font-size: 24px;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #ffffff;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
            transform: translateY(-4px);
        }

        .card-header {
            border-bottom: 1px solid #f3f4f6;
            font-weight: 600;
            padding: 20px 24px;
        }

        .card-body {
            padding: 24px;
        }

        /* Stat Cards */
        .stat-card {
            border: none;
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--card-color-start), var(--card-color-end));
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 32px rgba(0,0,0,0.12);
        }

        .stat-card.primary {
            --card-color-start: #667eea;
            --card-color-end: #764ba2;
        }

        .stat-card.success {
            --card-color-start: #10b981;
            --card-color-end: #059669;
        }

        .stat-card.warning {
            --card-color-start: #f59e0b;
            --card-color-end: #d97706;
        }

        .stat-card.danger {
            --card-color-start: #ef4444;
            --card-color-end: #dc2626;
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 24px;
        }

        /* Buttons */
        .btn {
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 10px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
        }

        /* Tables */
        .table {
            background: #ffffff;
            border-radius: 12px;
        }

        .table thead th {
            background: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
            color: #6b7280;
            padding: 16px;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: #f9fafb;
            transform: scale(1.01);
        }

        .table tbody td {
            padding: 16px;
            vertical-align: middle;
        }

        /* Forms */
        .form-control, .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        /* Badges */
        .badge {
            padding: 6px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.3px;
        }

        .badge-pending {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: #78350f;
        }
        .badge-confirmed {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
        }
        .badge-canceled {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #fff;
        }
        .badge-warning {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: #78350f;
        }
        .badge-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
        }
        .badge-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #fff;
        }
        .badge-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
        }
        .badge-secondary {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: #fff;
        }
        .badge-info {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
            color: #fff;
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 16px 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
        }

        .alert-info {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .sidebar {
                width: 220px;
            }
            .content-wrapper {
                margin-left: 220px;
            }
            .sidebar .nav-link {
                padding: 12px 16px;
                font-size: 14px;
            }
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 200px;
            }
            .content-wrapper {
                margin-left: 200px;
            }
            .navbar-brand-wrapper {
                padding: 20px 16px;
            }
            .top-navbar h5 {
                font-size: 20px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -260px;
                transition: left 0.3s ease;
                width: 260px;
            }
            .sidebar.show {
                left: 0;
            }
            .content-wrapper {
                margin-left: 0;
            }
            .top-navbar h5 {
                font-size: 18px;
            }
            .card-body {
                padding: 16px;
            }
            .stat-card .card-body {
                padding: 16px;
            }
            .stat-icon {
                width: 48px;
                height: 48px;
                font-size: 22px;
            }
            .table {
                font-size: 14px;
            }
            .table thead th {
                padding: 12px 8px;
                font-size: 12px;
            }
            .table tbody td {
                padding: 12px 8px;
            }
        }

        @media (max-width: 576px) {
            .btn {
                padding: 10px 16px;
                font-size: 14px;
            }
            .form-control, .form-select {
                padding: 10px 12px;
                font-size: 14px;
            }
            .top-navbar {
                padding: 12px 16px !important;
            }
            .top-navbar h5 {
                font-size: 16px;
            }
        }
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
                        <a class="nav-link {{ request()->routeIs('admin.treatments.*') ? 'active' : '' }}"
                           href="{{ route('admin.treatments.index') }}">
                            <i class="bi bi-prescription2 me-2"></i>Traitements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.consultations.*') ? 'active' : '' }}"
                           href="{{ route('admin.consultations.index') }}">
                            <i class="bi bi-clipboard2-pulse me-2"></i>Consultations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.medical-files.*') ? 'active' : '' }}"
                           href="{{ route('admin.medical-files.index') }}">
                            <i class="bi bi-file-earmark-medical me-2"></i>Fichiers Médicaux
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
        <main class="content-wrapper p-0">
            <!-- Top Navbar -->
            <nav class="top-navbar navbar navbar-expand-lg navbar-light px-4 py-3">
                <div class="container-fluid">
                    <h5 class="mb-0">@yield('page-title', 'Tableau de bord')</h5>
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center gap-2 px-3 py-2 bg-light rounded-pill">
                            <i class="bi bi-person-circle fs-5 text-primary"></i>
                            <span class="fw-semibold text-dark">{{ Auth::user()->name }}</span>
                        </div>
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
