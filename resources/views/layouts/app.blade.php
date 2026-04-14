<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arafah App - Klinik Management</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #1976d2;
            --accent-color: #e3f2fd;
            --text-dark: #2c3e50;
        }

        body {
            background: #f8f9fc;
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
        }

        .navbar {
            background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 0.75rem 1.5rem;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
        }

        .brand-icon {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px;
            border-radius: 10px;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .role-badge {
            background: rgba(255, 255, 255, 0.15);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .user-section {
            background: rgba(0, 0, 0, 0.1);
            padding: 5px 15px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .user-section:hover {
            background: rgba(0, 0, 0, 0.15);
        }

        .logout-btn {
            background-color: #ffffff;
            color: #d32f2f;
            border: none;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 6px 16px;
            border-radius: 50px;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background-color: #ffebee;
            color: #b71c1c;
            transform: scale(1.05);
        }

        .main-content {
            padding-top: 2rem;
            padding-bottom: 4rem;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #bbb;
        }

        .swal2-popup {
            border-radius: 15px !important;
            font-family: 'Inter', 'Segoe UI', Roboto, sans-serif !important;
            padding: 2rem !important;
        }

        .swal2-title {
            font-size: 1.5rem !important;
            font-weight: 600 !important;
            color: #334155 !important; 
        }

        .swal2-html-container {
            color: #64748b !important; 
        }

        .swal2-confirm {
            background-color: #0d6efd !important; 
            border-radius: 8px !important;
            padding: 10px 24px !important;
            font-weight: 500 !important;
            box-shadow: 0 4px 6px -1px rgba(13, 110, 253, 0.2) !important;
        }

        .swal2-cancel {
            border-radius: 8px !important;
            padding: 10px 24px !important;
            font-weight: 500 !important;
        }

        .swal2-icon {
            border-width: 2px !important;
        }

        .swal2-show {
            animation: swal2-show 0.3s ease-out !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <div class="brand-icon">
                <i class="fas fa-clinic-medical"></i>
            </div>
            <span>Arafah App</span>
            <div class="ms-3 d-none d-sm-block">
                <span class="role-badge">{{ auth()->user()->role }}</span>
            </div>
        </a>

        <div class="d-flex align-items-center gap-3">
            <div class="user-section d-none d-md-flex align-items-center me-2">
                <div class="text-end">
                    <div class="text-white small fw-bold" style="line-height: 1.2;">{{ auth()->user()->name }}</div>
                    <div class="text-white-50" style="font-size: 0.65rem;">Sesi Aktif</div>
                </div>
                <div class="ms-3 rounded-circle bg-white text-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: bold; font-size: 0.8rem;">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>

            <form method="POST" action="/logout" class="m-0">
                @csrf
                <button type="submit" class="logout-btn shadow-sm">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<main class="container main-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.min.js"></script>
</body>
</html>