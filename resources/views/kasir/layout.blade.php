<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kasir Dashboard') - Algo Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #ff6b35;
            --secondary: #ff8c61;
            --dark: #0f1419;
            --gray: #64748b;
            --light: #f8fafc;
            --border: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--light);
            color: var(--dark);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: var(--dark);
            color: white;
            padding: 0;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.2);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-logo {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .sidebar-title {
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .sidebar-subtitle {
            font-size: 0.7rem;
            opacity: 0.7;
            margin-top: 0.25rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 1rem 0;
        }

        .sidebar-menu li {
            padding: 0;
            margin: 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.875rem 1.5rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.05);
            color: white;
            border-left-color: var(--primary);
        }

        .sidebar-menu a.active {
            background: rgba(255,107,53,0.15);
            color: var(--primary);
            border-left-color: var(--primary);
            font-weight: 600;
        }

        .sidebar-menu i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .sidebar-user {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.3);
        }

        .sidebar-user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .sidebar-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .sidebar-user-name {
            font-size: 0.9rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .sidebar-user-name small {
            display: block;
            opacity: 0.7;
            font-size: 0.75rem;
            font-weight: 400;
            margin-top: 0.25rem;
        }

        .sidebar-logout {
            width: 100%;
            padding: 0.75rem;
            background: rgba(255,107,53,0.1);
            color: var(--primary);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .sidebar-logout:hover {
            background: var(--primary);
            color: white;
        }

        /* Main Content */
        .main-wrapper {
            margin-left: 280px;
            min-height: 100vh;
            background: var(--light);
        }

        .topbar {
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            letter-spacing: -0.02em;
        }

        .topbar-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .topbar-time {
            font-size: 0.875rem;
            color: var(--gray);
        }

        .content-wrapper {
            padding: 2rem;
        }

        /* Cards & Stats */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--border);
            margin-bottom: 1rem;
            transition: all 0.2s;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-color: var(--primary);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.pending {
            background: rgba(249, 115, 22, 0.1);
            color: #f97316;
        }

        .stat-icon.preparing {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .stat-icon.ready {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .stat-icon.revenue {
            background: rgba(168, 85, 247, 0.1);
            color: #a855f7;
        }

        .stat-content {
            flex: 1;
            margin-left: 1rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--gray);
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
        }

        /* Tables */
        .table-wrapper {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            color: var(--dark);
        }

        .table thead th {
            background: #f8fafc;
            border: none;
            padding: 1rem;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table tbody td {
            padding: 1rem;
            border: none;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: rgba(255,107,53,0.02);
        }

        /* Status Badges */
        .badge-pending {
            background: rgba(249, 115, 22, 0.1);
            color: #f97316;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-accepted {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-preparing {
            background: rgba(168, 85, 247, 0.1);
            color: #a855f7;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-ready {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-completed {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-cancelled {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary);
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: #ff5a1f;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255,107,53,0.3);
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid var(--border);
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            color: var(--dark);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-danger {
            background: #ef4444;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border: none;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            border-left: 4px solid #22c55e;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border-left: 4px solid #ef4444;
        }

        .alert-warning {
            background: rgba(249, 115, 22, 0.1);
            color: #f97316;
            border-left: 4px solid #f97316;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 250px;
            }

            .main-wrapper {
                margin-left: 250px;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .topbar {
                padding: 1rem;
            }

            .stat-card {
                flex-direction: column;
                text-align: center;
            }

            .stat-content {
                margin-left: 0;
                margin-top: 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-wrapper {
                margin-left: 0;
            }

            .topbar {
                flex-direction: column;
                gap: 1rem;
            }

            .table-wrapper {
                overflow-x: auto;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">AC</div>
            <div>
                <div class="sidebar-title">Algo Coffee</div>
                <div class="sidebar-subtitle">POS System</div>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('kasir.dashboard') }}" class="@if(request()->routeIs('kasir.dashboard')) active @endif">
                    <i class="fas fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('kasir.orders') }}" class="@if(request()->routeIs('kasir.orders*')) active @endif">
                    <i class="fas fa-list"></i>
                    <span>Pesanan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('kasir.history') }}" class="@if(request()->routeIs('kasir.history')) active @endif">
                    <i class="fas fa-history"></i>
                    <span>Riwayat</span>
                </a>
            </li>
            <li>
                <a href="{{ route('kasir.revenue') }}" class="@if(request()->routeIs('kasir.revenue')) active @endif">
                    <i class="fas fa-chart-line"></i>
                    <span>Pendapatan</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-user">
            <div class="sidebar-user-info">
                <div class="sidebar-user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div class="sidebar-user-name">
                    {{ auth()->user()->name }}
                    <small>{{ ucfirst(auth()->user()->role) }}</small>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-wrapper">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-title">@yield('page_title', 'Dashboard')</div>
            <div class="topbar-actions">
                <div class="topbar-time" id="current-time"></div>
            </div>
        </div>

        <!-- Alerts -->
        <div class="content-wrapper">
            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <strong>Error!</strong><br>
                        @foreach($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Update time
        function updateTime() {
            const now = new Date();
            const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            document.getElementById('current-time').textContent = now.toLocaleDateString('id-ID', options);
        }
        updateTime();
        setInterval(updateTime, 60000);

        // Auto-dismiss alerts
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 5000);
        });
    </script>

    @yield('scripts')
</body>
</html>
