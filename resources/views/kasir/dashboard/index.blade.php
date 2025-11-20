@extends('kasir.layout')

@section('title', 'Dashboard - Kasir')
@section('page_title', '📊 Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card pending-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-meta">
                    <span class="stat-label">Perlu Dikonfirmasi</span>
                    <span class="stat-subtitle">Menunggu tindakan</span>
                </div>
            </div>
            <div id="stat-pending" class="stat-number">{{ $pendingOrders }}</div>
        </div>

        <div class="stat-card preparing-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-fire"></i>
                </div>
                <div class="stat-meta">
                    <span class="stat-label">Sedang Diproses</span>
                    <span class="stat-subtitle">Dalam persiapan</span>
                </div>
            </div>
            <div id="stat-preparing" class="stat-number">{{ $preparingOrders }}</div>
        </div>

        <div class="stat-card ready-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-meta">
                    <span class="stat-label">Siap Diambil</span>
                    <span class="stat-subtitle">Tunggu customer</span>
                </div>
            </div>
            <div id="stat-ready" class="stat-number">{{ $readyOrders }}</div>
        </div>

        <div class="stat-card revenue-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-meta">
                    <span class="stat-label">Pendapatan Hari Ini</span>
                    <span class="stat-subtitle">Total transaksi</span>
                </div>
            </div>
            <div id="stat-revenue" class="stat-number">Rp{{ number_format($todayRevenue, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Performance & Popular Menu -->
    <div class="info-grid">
        <div class="info-card">
            <div class="card-header">
                <i class="fas fa-chart-line"></i>
                <h3>Performa Hari Ini</h3>
            </div>
            <div class="performance-metrics">
                <div class="metric">
                    <span class="metric-label">Total Pesanan</span>
                    <span class="metric-value">{{ $totalOrdersToday ?? 0 }}</span>
                </div>
                <div class="metric">
                    <span class="metric-label">Pesanan Selesai</span>
                    <span class="metric-value success">{{ $completedOrdersToday ?? 0 }}</span>
                </div>
            </div>
            <div class="average-time">
                <i class="fas fa-hourglass-half"></i>
                <span>Rata-rata waktu: <strong>{{ $averageTimeToday ?? 'N/A' }}</strong></span>
            </div>
        </div>

        <div class="info-card">
            <div class="card-header">
                <i class="fas fa-fire-flame-curved"></i>
                <h3>Menu Terpopuler</h3>
            </div>
            <div class="popular-menu-list">
                @forelse($topMenusToday ?? [] as $item)
                    <div class="menu-item">
                        <span class="menu-name">{{ $item['name'] ?? 'Menu' }}</span>
                        <span class="menu-count">{{ $item['count'] ?? 0 }}×</span>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-utensils"></i>
                        <span>Belum ada penjualan</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Active Orders Section -->
    <div class="orders-section">
        <div class="section-header">
            <div class="header-left">
                <i class="fas fa-list-check"></i>
                <h3>Pesanan Aktif</h3>
            </div>
            <div class="header-right">
                <span id="dashboard-loading" class="status-indicator loading" style="display:none;">
                    <i class="fas fa-spinner fa-spin"></i> Memuat…
                </span>
                <span id="dashboard-error" class="status-indicator error" style="display:none;">
                    <i class="fas fa-exclamation-circle"></i> Terputus
                </span>
                <span id="active-orders-count" class="order-badge">
                    {{ $pendingOrders + $preparingOrders + $readyOrders }} Pesanan
                </span>
            </div>
        </div>

        @php
            $activeOrders = $recentOrders->filter(function($o) { 
                return in_array($o->status, ['pending', 'accepted', 'preparing', 'ready']); 
            })->sortByDesc('created_at');
        @endphp

        @if($activeOrders->count() > 0)
            <div id="active-orders-list" class="orders-grid">
                @foreach($activeOrders->take(5) as $order)
                    <div class="order-card status-{{ $order->status }}">
                        <div class="order-header">
                            <div class="order-number">{{ $order->order_number }}</div>
                            <span class="status-badge {{ $order->status }}">
                                @if($order->status === 'pending') PENDING
                                @elseif($order->status === 'accepted') DITERIMA
                                @elseif($order->status === 'preparing') DIPROSES
                                @elseif($order->status === 'ready') SIAP
                                @endif
                            </span>
                        </div>
                        <div class="order-details">
                            <div class="detail-row">
                                <i class="fas fa-user"></i>
                                <span>{{ $order->customer_name }}</span>
                            </div>
                            <div class="detail-row">
                                <i class="fas fa-table"></i>
                                <span>Meja {{ $order->table->table_number }}</span>
                            </div>
                            <div class="detail-row">
                                <i class="fas fa-coins"></i>
                                <span class="price">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="order-items">
                            <i class="fas fa-utensils"></i>
                            <span>{{ implode(', ', $order->menus->pluck('name')->toArray()) }}</span>
                        </div>
                        <div class="order-footer">
                            <span class="order-time">
                                <i class="fas fa-clock"></i>
                                {{ $order->created_at->format('H:i') }}
                            </span>
                            <a href="{{ route('kasir.orders.show', $order) }}" class="btn-detail">
                                Detail <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            @if($activeOrders->count() > 5)
                <div class="view-more">
                    <a href="{{ route('kasir.orders') }}">
                        Lihat {{ $activeOrders->count() - 5 }} pesanan lainnya
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            @endif
        @else
            <div id="active-orders-list" class="empty-orders">
                <i class="fas fa-check-circle"></i>
                <h4>Semua pesanan selesai!</h4>
                <p>Tidak ada pesanan aktif saat ini 🎉</p>
            </div>
        @endif
    </div>

    <!-- Recent Orders Table -->
    <div class="table-section">
        <div class="section-header">
            <div class="header-left">
                <i class="fas fa-history"></i>
                <h3>Riwayat Pesanan Terbaru</h3>
            </div>
        </div>
        <div class="table-wrapper">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>No Pesanan</th>
                        <th>Nama Pemesan</th>
                        <th>Meja</th>
                        <th>Menu</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="recent-orders-body">
                    @forelse($recentOrders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->customer_name }}</td>
                            <td>Meja {{ $order->table->table_number }}</td>
                            <td class="menu-cell">
                                @foreach($order->menus as $menu)
                                    <div class="menu-item-row">{{ $menu->name }} ({{ $menu->pivot->quantity }}×)</div>
                                @endforeach
                            </td>
                            <td class="price-cell">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td>
                                <span class="status-badge {{ $order->status }}">
                                    @if($order->status === 'pending') Pending
                                    @elseif($order->status === 'accepted') Diterima
                                    @elseif($order->status === 'preparing') Diproses
                                    @elseif($order->status === 'ready') Siap
                                    @elseif($order->status === 'completed') Selesai
                                    @else Batal
                                    @endif
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('H:i') }}</td>
                            <td>
                                <a href="{{ route('kasir.orders.show', $order) }}" class="btn-table-action">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-table">
                                <i class="fas fa-inbox"></i>
                                <span>Tidak ada pesanan</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .dashboard-container {
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
        background: #fafafa;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.75rem;
        border: 2px solid transparent;
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
        height: 3px;
        background: linear-gradient(90deg, #ff6b35, #ff8c61);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(255, 107, 53, 0.15);
        border-color: #ff6b35;
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: linear-gradient(135deg, #ff6b35, #ff8c61);
        color: white;
        box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
    }

    .stat-meta {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .stat-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1a1a1a;
        letter-spacing: -0.01em;
    }

    .stat-subtitle {
        font-size: 0.75rem;
        color: #666;
        font-weight: 500;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #ff6b35;
        line-height: 1;
        letter-spacing: -0.02em;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-card {
        background: white;
        border-radius: 16px;
        padding: 1.75rem;
        border: 2px solid #f0f0f0;
        transition: all 0.3s;
    }

    .info-card:hover {
        border-color: #ff6b35;
        box-shadow: 0 8px 16px rgba(255, 107, 53, 0.1);
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f5f5f5;
    }

    .card-header i {
        font-size: 1.25rem;
        color: #ff6b35;
    }

    .card-header h3 {
        margin: 0;
        font-size: 1.125rem;
        font-weight: 700;
        color: #1a1a1a;
        letter-spacing: -0.01em;
    }

    .performance-metrics {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.25rem;
    }

    .metric {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .metric-label {
        font-size: 0.8125rem;
        color: #666;
        font-weight: 500;
    }

    .metric-value {
        font-size: 2rem;
        font-weight: 800;
        color: #1a1a1a;
        letter-spacing: -0.02em;
    }

    .metric-value.success {
        color: #10b981;
    }

    .average-time {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        background: #fafafa;
        border-radius: 10px;
        font-size: 0.875rem;
        color: #666;
    }

    .average-time i {
        color: #ff6b35;
    }

    .average-time strong {
        color: #1a1a1a;
        font-weight: 600;
    }

    .popular-menu-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .menu-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.875rem;
        background: #fafafa;
        border-radius: 10px;
        transition: all 0.2s;
    }

    .menu-item:hover {
        background: #fff5f2;
        transform: translateX(4px);
    }

    .menu-name {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 0.9375rem;
    }

    .menu-count {
        background: linear-gradient(135deg, #ff6b35, #ff8c61);
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.875rem;
    }

    /* Orders Section */
    .orders-section,
    .table-section {
        background: white;
        border-radius: 16px;
        padding: 1.75rem;
        margin-bottom: 2rem;
        border: 2px solid #f0f0f0;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f5f5f5;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .header-left i {
        font-size: 1.25rem;
        color: #ff6b35;
    }

    .header-left h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1a1a;
        letter-spacing: -0.01em;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .status-indicator {
        font-size: 0.8125rem;
        color: #666;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .status-indicator.error {
        color: #dc2626;
    }

    .order-badge {
        background: linear-gradient(135deg, #ff6b35, #ff8c61);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 700;
        letter-spacing: -0.01em;
    }

    /* Orders Grid */
    .orders-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 1.25rem;
    }

    .order-card {
        background: #fafafa;
        border-radius: 12px;
        padding: 1.25rem;
        border-left: 4px solid #ff6b35;
        transition: all 0.3s;
    }

    .order-card:hover {
        background: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }

    .order-card.status-pending {
        border-left-color: #ff6b35;
    }

    .order-card.status-accepted {
        border-left-color: #ff8c61;
    }

    .order-card.status-preparing {
        border-left-color: #ffa500;
    }

    .order-card.status-ready {
        border-left-color: #10b981;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .order-number {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1a1a1a;
        letter-spacing: -0.01em;
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }

    .status-badge.pending {
        background: #fee2e2;
        color: #dc2626;
    }

    .status-badge.accepted {
        background: #ffebcd;
        color: #ea580c;
    }

    .status-badge.preparing {
        background: #fff5e1;
        color: #f59e0b;
    }

    .status-badge.ready {
        background: #d1fae5;
        color: #059669;
    }

    .status-badge.completed {
        background: #e0e7ff;
        color: #4f46e5;
    }

    .status-badge.cancelled {
        background: #f3f4f6;
        color: #6b7280;
    }

    .order-details {
        display: flex;
        flex-direction: column;
        gap: 0.625rem;
        margin-bottom: 1rem;
    }

    .detail-row {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        font-size: 0.875rem;
        color: #666;
    }

    .detail-row i {
        width: 16px;
        color: #ff6b35;
        font-size: 0.875rem;
    }

    .detail-row .price {
        font-weight: 700;
        color: #1a1a1a;
    }

    .order-items {
        display: flex;
        align-items: flex-start;
        gap: 0.625rem;
        padding: 0.875rem;
        background: white;
        border-radius: 8px;
        font-size: 0.8125rem;
        color: #666;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .order-items i {
        color: #ff6b35;
        font-size: 0.875rem;
        margin-top: 0.125rem;
        flex-shrink: 0;
    }

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .order-time {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: #666;
    }

    .order-time i {
        color: #ff6b35;
    }

    .btn-detail {
        background: linear-gradient(135deg, #ff6b35, #ff8c61);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.8125rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s;
        letter-spacing: -0.01em;
    }

    .btn-detail:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        color: white;
    }

    /* Empty States */
    .empty-orders,
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        text-align: center;
        color: #999;
    }

    .empty-orders i,
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #ddd;
    }

    .empty-orders h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 0.5rem 0;
    }

    .empty-orders p {
        color: #666;
        margin: 0;
    }

    .view-more {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 2px solid #f5f5f5;
    }

    .view-more a {
        color: #ff6b35;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9375rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }

    .view-more a:hover {
        gap: 0.75rem;
        color: #ff8c61;
    }

    /* Table Styles */
    .table-wrapper {
        overflow-x: auto;
        border-radius: 12px;
        border: 1px solid #f0f0f0;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table thead th {
        background: #fafafa;
        padding: 1rem 1.25rem;
        text-align: left;
        font-size: 0.8125rem;
        font-weight: 700;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #f0f0f0;
    }

    .orders-table tbody tr {
        border-bottom: 1px solid #f5f5f5;
        transition: all 0.2s;
    }

    .orders-table tbody tr:hover {
        background: #fafafa;
    }

    .orders-table tbody td {
        padding: 1.25rem;
        font-size: 0.9375rem;
        color: #1a1a1a;
    }

    .orders-table .menu-cell {
        font-size: 0.8125rem;
        color: #666;
    }

    .orders-table .menu-item-row {
        padding: 0.25rem 0;
    }

    .orders-table .price-cell {
        font-weight: 700;
        color: #ff6b35;
    }

    .btn-table-action {
        background: #fafafa;
        color: #1a1a1a;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid #f0f0f0;
    }

    .btn-table-action:hover {
        background: linear-gradient(135deg, #ff6b35, #ff8c61);
        color: white;
        border-color: #ff6b35;
        transform: scale(1.1);
    }

    .empty-table {
        text-align: center;
        padding: 3rem 1rem !important;
    }

    .empty-table i {
        display: block;
        font-size: 2.5rem;
        color: #ddd;
        margin-bottom: 0.75rem;
    }

    .empty-table span {
        color: #999;
        font-size: 0.9375rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .orders-grid {
            grid-template-columns: 1fr;
        }

        .stat-number {
            font-size: 2rem;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .orders-table thead {
            display: none;
        }

        .orders-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #f0f0f0;
            border-radius: 12px;
            overflow: hidden;
        }

        .orders-table tbody td {
            display: block;
            text-align: right;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f5f5f5;
            position: relative;
            padding-left: 50%;
        }

        .orders-table tbody td:last-child {
            border-bottom: none;
        }

        .orders-table tbody td::before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            font-weight: 700;
            color: #666;
            text-align: left;
        }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card,
    .info-card,
    .order-card {
        animation: fadeInUp 0.5s ease-out backwards;
    }

    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.1s; }
    .stat-card:nth-child(3) { animation-delay: 0.15s; }
    .stat-card:nth-child(4) { animation-delay: 0.2s; }
</style>

<script>
    // Polling API untuk memperbarui statistik dan daftar pesanan
    (function () {
        const endpoint = '{{ route('kasir.api.dashboard') }}';
        let lastDataHash = null;
        let errorCount = 0;
        const MAX_ERRORS = 4;

        function formatCurrency(num) {
            try {
                return 'Rp' + Number(num).toLocaleString('id-ID');
            } catch (e) {
                return 'Rp' + num;
            }
        }

        function buildOrderCard(order) {
            const statusClass = order.status || 'pending';
            const statusText = {
                pending: 'PENDING',
                accepted: 'DITERIMA',
                preparing: 'DIPROSES',
                ready: 'SIAP'
            }[statusClass] || 'PENDING';

            const menuNames = (order.menus || []).map(m => m.name).join(', ');
            const tableNumber = order.table?.table_number ?? order.table_number ?? '-';

            return `
                <div class="order-card status-${statusClass}">
                    <div class="order-header">
                        <div class="order-number">${order.order_number}</div>
                        <span class="status-badge ${statusClass}">${statusText}</span>
                    </div>
                    <div class="order-details">
                        <div class="detail-row">
                            <i class="fas fa-user"></i>
                            <span>${order.customer_name}</span>
                        </div>
                        <div class="detail-row">
                            <i class="fas fa-table"></i>
                            <span>Meja ${tableNumber}</span>
                        </div>
                        <div class="detail-row">
                            <i class="fas fa-coins"></i>
                            <span class="price">${formatCurrency(order.total_price)}</span>
                        </div>
                    </div>
                    <div class="order-items">
                        <i class="fas fa-utensils"></i>
                        <span>${menuNames}</span>
                    </div>
                    <div class="order-footer">
                        <span class="order-time">
                            <i class="fas fa-clock"></i>
                            ${new Date(order.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                        </span>
                        <a href="/kasir/orders/${order.id}" class="btn-detail">
                            Detail <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            `;
        }

        function updateDOM(data) {
            if (!data) return;

            // Update stats
            const pendingEl = document.getElementById('stat-pending');
            const preparingEl = document.getElementById('stat-preparing');
            const readyEl = document.getElementById('stat-ready');
            const revenueEl = document.getElementById('stat-revenue');
            const activeCountEl = document.getElementById('active-orders-count');

            const counts = data.counts ?? {
                pending: data.pending ?? 0,
                accepted: data.accepted ?? 0,
                preparing: data.preparing ?? 0,
                ready: data.ready ?? 0,
            };

            if (pendingEl) pendingEl.textContent = counts.pending ?? 0;
            if (preparingEl) preparingEl.textContent = (counts.preparing ?? 0) + (counts.accepted ?? 0);
            if (readyEl) readyEl.textContent = counts.ready ?? 0;
            if (revenueEl) revenueEl.textContent = formatCurrency(data.todayRevenue ?? 0);

            const totalActive = (counts.pending ?? 0) + (counts.preparing ?? 0) + (counts.accepted ?? 0) + (counts.ready ?? 0);
            if (activeCountEl) activeCountEl.textContent = `${totalActive} Pesanan`;

            // Update active orders list
            const activeContainer = document.getElementById('active-orders-list');
            if (activeContainer) {
                const activeOrders = (data.recentOrders || [])
                    .filter(o => ['pending','accepted','preparing','ready'].includes(o.status))
                    .sort((a,b) => new Date(b.created_at) - new Date(a.created_at))
                    .slice(0, 5);
                
                if (activeOrders.length > 0) {
                    activeContainer.innerHTML = activeOrders.map(buildOrderCard).join('');
                } else {
                    activeContainer.innerHTML = `
                        <div class="empty-orders">
                            <i class="fas fa-check-circle"></i>
                            <h4>Semua pesanan selesai!</h4>
                            <p>Tidak ada pesanan aktif saat ini 🎉</p>
                        </div>
                    `;
                }
            }

            // Update recent orders table
            const recentBody = document.getElementById('recent-orders-body');
            if (recentBody) {
                const rows = (data.recentOrders || []).map(order => {
                    const menusHtml = (order.menus || []).map(m => {
                        const qty = m.qty ?? (m.pivot ? m.pivot.quantity : (m.quantity || 1));
                        return `<div class="menu-item-row">${m.name} (${qty}×)</div>`;
                    }).join('');
                    
                    const statusClass = order.status || 'pending';
                    const statusText = {
                        pending: 'Pending',
                        accepted: 'Diterima',
                        preparing: 'Diproses',
                        ready: 'Siap',
                        completed: 'Selesai',
                        cancelled: 'Batal'
                    }[statusClass] || 'Pending';

                    const tableNumber = order.table?.table_number ?? order.table_number ?? '-';

                    return `
                        <tr>
                            <td data-label="No Pesanan"><strong>${order.order_number}</strong></td>
                            <td data-label="Nama Pemesan">${order.customer_name}</td>
                            <td data-label="Meja">Meja ${tableNumber}</td>
                            <td data-label="Menu" class="menu-cell">${menusHtml}</td>
                            <td data-label="Total" class="price-cell">${formatCurrency(order.total_price)}</td>
                            <td data-label="Status"><span class="status-badge ${statusClass}">${statusText}</span></td>
                            <td data-label="Waktu">${new Date(order.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</td>
                            <td data-label="Aksi">
                                <a href="/kasir/orders/${order.id}" class="btn-table-action">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    `;
                }).join('');

                recentBody.innerHTML = rows || `
                    <tr>
                        <td colspan="8" class="empty-table">
                            <i class="fas fa-inbox"></i>
                            <span>Tidak ada pesanan</span>
                        </td>
                    </tr>
                `;
            }
        }

        async function poll() {
            try {
                const res = await fetch(endpoint, { 
                    headers: { 'X-Requested-With': 'XMLHttpRequest' } 
                });
                
                if (!res.ok) throw new Error('Network response not ok');
                
                const data = await res.json();
                
                // Hide loading/error indicators
                const loadingEl = document.getElementById('dashboard-loading');
                const errorEl = document.getElementById('dashboard-error');
                if (loadingEl) loadingEl.style.display = 'none';
                if (errorEl) errorEl.style.display = 'none';

                // Update DOM if data changed
                try {
                    const hash = JSON.stringify(data);
                    if (hash !== lastDataHash) {
                        lastDataHash = hash;
                        updateDOM(data);
                    }
                } catch (e) {
                    updateDOM(data);
                }

                errorCount = 0;
            } catch (err) {
                console.error('Dashboard poll error:', err);
                
                const loadingEl = document.getElementById('dashboard-loading');
                const errorEl = document.getElementById('dashboard-error');
                
                if (loadingEl) loadingEl.style.display = 'none';
                
                errorCount++;
                if (errorEl && errorCount >= 2) {
                    errorEl.style.display = 'inline-block';
                }
            }
        }

        // Initial poll and set interval
        poll();
        setInterval(poll, 10000); // Poll every 10 seconds
    })();
</script>
@endsection