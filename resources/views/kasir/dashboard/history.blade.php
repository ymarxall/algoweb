@extends('kasir.layout')

@section('title', 'Riwayat Pesanan - Kasir')
@section('page_title', '📅 Riwayat Pesanan')

@section('content')
<div class="modern-container">
    <!-- Month Selector -->
    <div class="month-section">
        <form method="GET" class="month-form">
            <label class="month-label">Pilih Bulan</label>
            <input type="month" name="month" class="month-input" value="{{ request('month', now()->format('Y-m')) }}" onchange="this.form.submit()">
            <span class="month-display">{{ now()->parse(request('month', now()->format('Y-m')))->format('F Y') }}</span>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-value">{{ $stats['total_orders'] }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🛒</div>
            <div class="stat-content">
                <div class="stat-label">Total Item</div>
                <div class="stat-value">{{ $stats['total_items'] }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-content">
                <div class="stat-label">Total Pemasukan</div>
                <div class="stat-value stat-orange">Rp{{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📈</div>
            <div class="stat-content">
                <div class="stat-label">Rata-rata Pesanan</div>
                <div class="stat-value stat-orange">Rp{{ number_format($stats['avg_order'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="table-card">
        <div class="table-header">
            <h2 class="table-title">Daftar Pesanan</h2>
            <span class="order-count">{{ count($orders) }} pesanan</span>
        </div>
        
        <div class="table-wrapper">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pemesan</th>
                        <th>Meja</th>
                        <th>Item</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="order-row">
                            <td class="col-number">{{ $order->order_number }}</td>
                            <td class="col-name">{{ $order->customer_name }}</td>
                            <td class="col-table">M{{ $order->table->table_number ?? '-' }}</td>
                            <td class="col-items">{{ $order->menus->sum(fn($m) => $m->pivot->quantity) }}</td>
                            <td class="col-price">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="col-payment">
                                @if($order->payment_method === 'cash')
                                    <span class="badge payment-cash">💵 Tunai</span>
                                @else
                                    <span class="badge payment-card">💳 Kartu</span>
                                @endif
                            </td>
                            <td class="col-status">
                                @if($order->status === 'pending')
                                    <span class="status pending">⏳ Pending</span>
                                @elseif($order->status === 'accepted')
                                    <span class="status accepted">✓ Terima</span>
                                @elseif($order->status === 'preparing')
                                    <span class="status preparing">🔥 Proses</span>
                                @elseif($order->status === 'ready')
                                    <span class="status ready">🎉 Siap</span>
                                @elseif($order->status === 'completed')
                                    <span class="status completed">✓✓ Selesai</span>
                                @else
                                    <span class="status cancelled">✕ Batal</span>
                                @endif
                            </td>
                            <td class="col-time">{{ $order->created_at->format('d M H:i') }}</td>
                            <td class="col-action">
                                <a href="{{ route('kasir.orders.show', $order) }}" class="btn-detail">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="9">
                                <div class="empty-state">
                                    <div class="empty-icon">📭</div>
                                    <p class="empty-text">Tidak ada pesanan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="pagination-section">
                <nav aria-label="Navigasi halaman">
                    <ul class="pagination">
                        <!-- Previous -->
                        @if($orders->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">Sebelumnya</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $orders->previousPageUrl() }}" rel="prev">
                                    Sebelumnya
                                </a>
                            </li>
                        @endif

                        <!-- Page Numbers -->
                        @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            @if($page == $orders->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        <!-- Next -->
                        @if($orders->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $orders->nextPageUrl() }}" rel="next">
                                    Berikutnya
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Berikutnya</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif
    </div>
</div>

<style>
    :root {
        --primary-orange: #FF8C42;
        --primary-white: #FFFFFF;
        --primary-black: #1a1a1a;
        --gray-50: #f9f9f9;
        --gray-100: #f3f3f3;
        --gray-200: #e8e8e8;
        --gray-300: #d0d0d0;
        --gray-600: #666666;
        --gray-700: #444444;
    }

    .modern-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1.5rem;
        background: var(--primary-white);
        min-height: 100vh;
    }

    /* Month Section */
    .month-section {
        margin-bottom: 2rem;
    }

    .month-form {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .month-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary-black);
        margin: 0;
        white-space: nowrap;
    }

    .month-input {
        padding: 0.6rem 0.9rem;
        border: 2px solid var(--gray-200);
        border-radius: 6px;
        font-size: 0.9rem;
        color: var(--primary-black);
        background: var(--primary-white);
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .month-input:hover,
    .month-input:focus {
        border-color: var(--primary-orange);
        outline: none;
        box-shadow: 0 0 0 3px rgba(255, 140, 66, 0.1);
    }

    .month-display {
        padding: 0.6rem 1rem;
        background: rgba(255, 140, 66, 0.1);
        color: var(--primary-orange);
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.2rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.2rem;
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        background: var(--primary-white);
        border-color: var(--primary-orange);
        box-shadow: 0 4px 12px rgba(255, 140, 66, 0.12);
        transform: translateY(-2px);
    }

    .stat-icon {
        font-size: 2rem;
        min-width: 2.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-content {
        flex: 1;
    }

    .stat-label {
        font-size: 0.8rem;
        color: var(--gray-600);
        margin-bottom: 0.3rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .stat-value {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary-black);
        line-height: 1.2;
    }

    .stat-orange {
        color: var(--primary-orange);
    }

    /* Table Card */
    .table-card {
        background: var(--primary-white);
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table-header {
        padding: 1.3rem;
        border-bottom: 2px solid var(--gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .table-title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary-black);
        letter-spacing: -0.3px;
    }

    .order-count {
        font-size: 0.85rem;
        color: var(--gray-600);
        background: var(--gray-100);
        padding: 0.4rem 0.9rem;
        border-radius: 16px;
        white-space: nowrap;
    }

    /* Table Wrapper */
    .table-wrapper {
        overflow-x: auto;
    }

    .table-wrapper::-webkit-scrollbar {
        height: 6px;
    }

    .table-wrapper::-webkit-scrollbar-track {
        background: var(--gray-100);
    }

    .table-wrapper::-webkit-scrollbar-thumb {
        background: var(--gray-300);
        border-radius: 3px;
    }

    .table-wrapper::-webkit-scrollbar-thumb:hover {
        background: var(--gray-600);
    }

    /* Orders Table */
    .orders-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .orders-table thead {
        background: var(--gray-100);
        border-bottom: 2px solid var(--primary-orange);
    }

    .orders-table thead th {
        padding: 0.9rem 0.8rem;
        text-align: left;
        font-weight: 600;
        color: var(--primary-black);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }

    .orders-table tbody tr {
        border-bottom: 1px solid var(--gray-200);
        transition: background 0.2s ease;
    }

    .orders-table tbody tr:hover {
        background: var(--gray-50);
    }

    .order-row td {
        padding: 0.85rem 0.8rem;
        color: var(--primary-black);
        font-size: 0.9rem;
    }

    .col-number {
        font-weight: 600;
        color: var(--primary-black);
    }

    .col-name {
        font-weight: 500;
    }

    .col-table {
        color: var(--gray-600);
        font-size: 0.85rem;
    }

    .col-items {
        text-align: center;
        font-weight: 500;
    }

    .col-price {
        font-weight: 600;
        color: var(--primary-orange);
    }

    .col-payment {
        text-align: center;
    }

    .col-status {
        text-align: center;
    }

    .col-time {
        color: var(--gray-600);
        font-size: 0.85rem;
    }

    .col-action {
        text-align: center;
    }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .payment-cash {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .payment-card {
        background: #E3F2FD;
        color: #1565C0;
    }

    /* Status Badges */
    .status {
        display: inline-block;
        padding: 0.35rem 0.7rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .status.pending {
        background: rgba(255, 140, 66, 0.15);
        color: var(--primary-orange);
    }

    .status.accepted {
        background: #F3E5F5;
        color: #7B1FA2;
    }

    .status.preparing {
        background: #FCE4EC;
        color: #C2185B;
    }

    .status.ready {
        background: rgba(255, 140, 66, 0.15);
        color: var(--primary-orange);
    }

    .status.completed {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .status.cancelled {
        background: #FFEBEE;
        color: #C62828;
    }

    /* Action Button */
    .btn-detail {
        color: var(--primary-orange);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
        border-radius: 4px;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-block;
    }

    .btn-detail:hover {
        color: var(--primary-white);
        background: var(--primary-orange);
        text-decoration: none;
    }

    /* Empty State */
    .empty-row td {
        padding: 2.5rem !important;
    }

    .empty-state {
        text-align: center;
    }

    .empty-icon {
        font-size: 2.5rem;
        margin-bottom: 0.8rem;
        opacity: 0.5;
    }

    .empty-text {
        margin: 0;
        color: var(--gray-600);
        font-size: 0.95rem;
    }

    /* Pagination */
    .pagination-section {
        padding: 1rem;
        display: flex;
        justify-content: center;
        border-top: 1px solid var(--gray-200);
    }

    .pagination-section .pagination {
        display: flex;
        gap: 0.3rem;
        list-style: none;
        margin: 0;
        padding: 0;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination-section .page-item {
        margin: 0;
    }

    .pagination-section .page-link {
        color: var(--primary-orange);
        border: 1px solid var(--gray-200);
        padding: 0.5rem 0.75rem;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.2s ease;
        display: block;
        min-width: 2.2rem;
        text-align: center;
    }

    .pagination-section .page-link:hover {
        background: var(--primary-orange);
        color: var(--primary-white);
        border-color: var(--primary-orange);
    }

    .pagination-section .page-item.active .page-link {
        background: var(--primary-orange);
        color: var(--primary-white);
        border-color: var(--primary-orange);
    }

    .pagination-section .page-item.disabled .page-link {
        color: var(--gray-300);
        cursor: not-allowed;
        background: var(--gray-50);
        border-color: var(--gray-200);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .modern-container {
            padding: 1rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .stat-card {
            padding: 1rem;
        }

        .stat-icon {
            font-size: 1.5rem;
        }

        .stat-value {
            font-size: 1.2rem;
        }

        .table-header {
            padding: 1rem;
            flex-direction: column;
            align-items: flex-start;
        }

        .table-title {
            font-size: 1.1rem;
        }

        .orders-table thead th,
        .order-row td {
            padding: 0.7rem 0.6rem;
            font-size: 0.8rem;
        }

        .month-form {
            gap: 0.8rem;
        }

        .order-count {
            font-size: 0.8rem;
            padding: 0.3rem 0.7rem;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stat-card {
            gap: 0.8rem;
        }

        .stat-label {
            font-size: 0.75rem;
        }

        .stat-value {
            font-size: 1.1rem;
        }
    }
</style>
@endsection