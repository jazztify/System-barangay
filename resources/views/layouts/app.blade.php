<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Barangay Information System</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Theme style (AdminLTE 4 - using BS5 as base) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <style>
        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary: #475569;
        }
        .main-sidebar { background-color: #1e293b !important; }
        .nav-link.active { background-color: var(--primary) !important; color: #fff !important; }
        .brand-link { background-color: #0f172a !important; color: #fff !important; border-bottom: 1px solid #334155 !important; }
        .content-wrapper { background-color: #f8fafc; }
        .card { border: none; box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1); border-radius: 0.5rem; }
        .card-header { background-color: #fff; border-bottom: 1px solid #f1f5f9; padding: 1.25rem; font-weight: 600; }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background-color: var(--primary-dark); border-color: var(--primary-dark); }
        
        /* Sidebar dark theme overrides */
        [class*=sidebar-dark-] .sidebar a { color: #cbd5e1; }
        [class*=sidebar-dark-] .sidebar a:hover { color: #fff; background-color: rgba(255,255,255,.1); }
        [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link { color: #94a3b8; }
        
        @media print {
            .main-sidebar, .main-header, .footer, .btn, .no-print { display: none !important; }
            .content-wrapper { margin-left: 0 !important; background: white !important; }
            .card { box-shadow: none !important; border: none !important; }
        }
    </style>
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom-0">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <span class="nav-link font-weight-bold text-dark">@yield('header_title')</span>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="far fa-user-circle me-1"></i> {{ auth()->user()->full_name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a></li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-0">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link text-center py-3">
            <span class="brand-text font-weight-bold">BARANGAY BIS</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-3">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bx bxs-dashboard"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-header">CORE MODULES</li>
                    <li class="nav-item">
                        <a href="{{ route('residents.index') }}" class="nav-link {{ request()->routeIs('residents.*') ? 'active' : '' }}">
                            <i class="nav-icon bx bxs-group"></i>
                            <p>Residents (RBI)</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('households.index') }}" class="nav-link {{ request()->routeIs('households.*') ? 'active' : '' }}">
                            <i class="nav-icon bx bxs-home-alt-2"></i>
                            <p>Households</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('blotters.index') }}" class="nav-link {{ request()->routeIs('blotters.*') ? 'active' : '' }}">
                            <i class="nav-icon bx bxs-error-circle"></i>
                            <p>Blotter & Peace</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('documents.index') }}" class="nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}">
                            <i class="nav-icon bx bxs-file-doc"></i>
                            <p>Issuances & Docs</p>
                        </a>
                    </li>
                    <li class="nav-header">SYSTEM</li>
                    <li class="nav-item">
                        <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                            <i class="nav-icon bx bxs-cog"></i>
                            <p>Settings</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper px-3 py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer bg-white border-top-0 text-sm py-3">
        <strong>&copy; {{ date('Y') }} Barangay Information System.</strong>
        All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
@stack('scripts')
</body>
</html>
