<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Sistem Informasi Prakerin</title>

    <!-- Google Fonts: Inter and Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Premium Custom Styles -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            --secondary-gradient: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
            --success-gradient: linear-gradient(135deg, #34d399 0%, #059669 100%);
            --warning-gradient: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
            --danger-gradient: linear-gradient(135deg, #f87171 0%, #dc2626 100%);
            --glass-bg: rgba(255, 255, 255, 0.85);
            --body-bg: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
        }

        /* Glassmorphic Navbar */
        .custom-navbar {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .navbar-brand {
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.4rem;
        }

        /* Premium Cards */
        .premium-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.03);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .premium-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
        }

        /* Welcome Preview Card custom floating animation and shadow */
        @keyframes premium-float {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-12px);
            }
            100% {
                transform: translateY(0);
            }
        }

        .welcome-float-wrapper {
            display: block;
            animation: premium-float 6s ease-in-out infinite;
        }

        .welcome-preview-card {
            border-radius: 24px !important;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.12), 0 1px 3px rgba(0, 0, 0, 0.05) !important;
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.4s ease !important;
        }

        .welcome-preview-card:hover {
            transform: scale(1.025) !important;
            box-shadow: 0 30px 60px rgba(99, 102, 241, 0.22), 0 2px 8px rgba(0, 0, 0, 0.06) !important;
        }

        /* Premium Buttons */
        .btn-gradient-primary {
            background: var(--primary-gradient);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .btn-gradient-primary:hover {
            opacity: 0.95;
            transform: scale(1.02);
            color: #ffffff;
        }

        .btn-gradient-success {
            background: var(--success-gradient);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .btn-gradient-success:hover {
            opacity: 0.95;
            transform: scale(1.02);
            color: #ffffff;
        }

        .btn-gradient-danger {
            background: var(--danger-gradient);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .btn-gradient-danger:hover {
            opacity: 0.95;
            transform: scale(1.02);
            color: #ffffff;
        }

        /* Custom Badges */
        .badge-pending {
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
            background-color: rgba(251, 191, 36, 0.15);
            color: #d97706;
            border: 1px solid rgba(251, 191, 36, 0.3);
            border-radius: 30px;
            padding: 6px 14px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .badge-approved {
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
            background-color: rgba(52, 211, 153, 0.15);
            color: #059669;
            border: 1px solid rgba(52, 211, 153, 0.3);
            border-radius: 30px;
            padding: 6px 14px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .badge-rejected {
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
            background-color: rgba(248, 113, 113, 0.15);
            color: #dc2626;
            border: 1px solid rgba(248, 113, 113, 0.3);
            border-radius: 30px;
            padding: 6px 14px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Stat Card styling */
        .stat-card {
            border-radius: 16px;
            border: none;
            color: white;
            padding: 24px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
        }
        .stat-card.primary { background: var(--primary-gradient); }
        .stat-card.success { background: var(--success-gradient); }
        .stat-card.warning { background: var(--warning-gradient); }
        .stat-card.danger { background: var(--danger-gradient); }

        .stat-card-icon {
            font-size: 2.2rem;
            opacity: 0.8;
        }

        /* Table styling */
        .table-responsive {
            border-radius: 16px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            background: white;
        }
        .custom-table th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
            padding: 16px 20px;
        }
        .custom-table td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Footer styling */
        footer {
            margin-top: auto;
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 20px 0;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        /* Alerts Custom */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
        }

        /* Professional Form Fields Focus and Required Indicators */
        .form-control:focus,
        .form-select:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.18) !important;
        }

        label:has(~ input[required])::after,
        label:has(~ select[required])::after,
        label:has(~ textarea[required])::after,
        .form-label:has(~ input[required])::after,
        .form-label:has(~ select[required])::after,
        .form-label:has(~ textarea[required])::after,
        .required::after {
            content: " *";
            color: #ef4444;
            font-weight: 600;
            margin-left: 2px;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fa-solid fa-graduation-cap me-2"></i>E-Prakerin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link px-3 {{ Request::is('dashboard') || Request::is('admin') || Request::is('prakerin') ? 'text-primary fw-semibold' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fa-solid fa-chart-line me-1"></i>Dashboard
                            </a>
                        </li>
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link px-3 {{ Request::is('admin/prakerin/create') ? 'text-primary fw-semibold' : '' }}" href="{{ route('admin.prakerin.create') }}">
                                    <i class="fa-solid fa-user-plus me-1"></i>Tambah Prakerin
                                </a>
                            </li>
                        @endif
                        <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2 w-100 rounded-pill px-3" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-circle-user text-primary fs-5"></i>
                                    <span>{{ Auth::user()->name }}</span>
                                    <span class="badge bg-secondary text-capitalize fs-7 py-1">{{ Auth::user()->role }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2 rounded-3" aria-labelledby="userMenu">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger rounded-2 d-flex align-items-center gap-2">
                                                <i class="fa-solid fa-right-from-bracket"></i> Keluar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link px-3 {{ Request::is('login') ? 'text-primary fw-semibold' : '' }}" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-gradient-primary rounded-pill px-4" href="{{ route('register') }}">Daftar Prakerin</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="py-4 my-2">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm d-flex align-items-center gap-3" role="alert">
                    <i class="fa-solid fa-circle-check fs-4"></i>
                    <div>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any() && !Request::is('login') && !Request::is('register'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm d-flex align-items-center gap-3" role="alert">
                    <i class="fa-solid fa-circle-exclamation fs-4"></i>
                    <div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }}  PKL Stikom 2026</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
