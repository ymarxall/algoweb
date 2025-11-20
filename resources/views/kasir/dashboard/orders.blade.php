@extends('kasir.layout')

@section('title', 'Pesanan - Kasir')
@section('page_title', '📋 Kelola Pesanan')

@section('content')
<div class="container-fluid">
    <!-- Filter & Stats -->
    <div class="row mb-4">
        <div class="col-12">
            <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; margin-bottom: 1rem;">
                <h6 style="margin: 0; color: #666;">Filter Status:</h6>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="{{ route('kasir.orders') }}" class="btn-secondary @if(!request('status')) active @endif" style="border: 2px solid var(--primary); color: var(--primary);">
                        <i class="fas fa-inbox"></i> Semua ({{ $stats['pending'] + $stats['accepted'] + $stats['preparing'] }})
                    </a>
                    <a href="{{ route('kasir.orders', ['status' => 'pending']) }}" class="btn-secondary @if(request('status') === 'pending') active @endif">
                        <i class="fas fa-clock"></i> Pending ({{ $stats['pending'] }})
                    </a>
                    <a href="{{ route('kasir.orders', ['status' => 'accepted']) }}" class="btn-secondary @if(request('status') === 'accepted') active @endif">
                        <i class="fas fa-check"></i> Diterima ({{ $stats['accepted'] }})
                    </a>
                    <a href="{{ route('kasir.orders', ['status' => 'preparing']) }}" class="btn-secondary @if(request('status') === 'preparing') active @endif">
                        <i class="fas fa-fire"></i> Diproses ({{ $stats['preparing'] }})
                    </a>
                </div>
            </div>
            <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border-left: 4px solid var(--primary);">
                <p style="margin: 0; font-size: 0.875rem; color: #666;">
                    <strong>Alur Pesanan:</strong> Pending → Diterima → Diproses → Siap → Selesai (atau Ditolak jika ada masalah)
                </p>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="row">
        <div class="col-12">
            <div class="table-wrapper">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No Pesanan</th>
                            <th>Nama Pemesan</th>
                            <th>Meja</th>
                            <th>Total Pesanan</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td><strong>{{ $order->order_number }}</strong></td>
                                <td>{{ $order->customer_name }}</td>
                                <td>Meja {{ $order->table->table_number ?? '-' }}</td>
                                <td>
                                    {{ $order->menus->sum(fn($m) => $m->pivot->quantity) }} item
                                </td>
                                <td><strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
                                <td>
                                    @if($order->status === 'pending')
                                        <span class="badge-pending">
                                            <i class="fas fa-exclamation-circle"></i> Menunggu Konfirmasi
                                        </span>
                                    @elseif($order->status === 'accepted')
                                        <span class="badge-accepted">
                                            <i class="fas fa-check"></i> Diterima
                                        </span>
                                    @elseif($order->status === 'preparing')
                                        <span class="badge-preparing">
                                            <i class="fas fa-fire"></i> Sedang Diproses
                                        </span>
                                    @elseif($order->status === 'ready')
                                        <span class="badge-ready">
                                            <i class="fas fa-check-circle"></i> Siap Disajikan
                                        </span>
                                    @elseif($order->status === 'completed')
                                        <span class="badge-completed">
                                            <i class="fas fa-flag-checkered"></i> Selesai
                                        </span>
                                    @elseif($order->status === 'rejected')
                                        <span class="badge-rejected">
                                            <i class="fas fa-times-circle"></i> Ditolak
                                        </span>
                                    @else
                                        <span class="badge-cancelled">
                                            <i class="fas fa-ban"></i> Dibatalkan
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('H:i') }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                                        @if($order->status === 'pending')
                                            <div style="display: flex; gap: 0.3rem;">
                                                <form action="{{ route('kasir.orders.accept', $order) }}" method="POST" style="margin:0;">
                                                    @csrf
                                                    <button type="submit" class="btn-action btn-accept" title="Terima pesanan">
                                                        <i class="fas fa-check"></i> Terima
                                                    </button>
                                                </form>
                                                <button type="button" class="btn-action btn-danger" onclick="showRejectForm({{ $order->id }})" title="Tolak pesanan">
                                                    <i class="fas fa-times"></i> Tolak
                                                </button>
                                            </div>
                                        @elseif($order->status === 'accepted')
                                            <form action="{{ route('kasir.orders.updateStatus', $order) }}" method="POST" style="margin:0;">
                                                @csrf
                                                <input type="hidden" name="status" value="preparing">
                                                <div style="display: flex; gap: 0.3rem; align-items: center;">
                                                    <input type="number" name="estimated_minutes" class="form-control form-control-sm" placeholder="Min" value="15" min="1" style="width: 60px; padding: 0.25rem;">
                                                    <button type="submit" class="btn-action btn-preparing" title="Mulai proses dengan estimasi waktu">
                                                        <i class="fas fa-fire"></i> Proses
                                                    </button>
                                                </div>
                                            </form>
                                        @elseif($order->status === 'preparing')
                                            <form action="{{ route('kasir.orders.updateStatus', $order) }}" method="POST" style="margin:0;">
                                                @csrf
                                                <input type="hidden" name="status" value="ready">
                                                <button type="submit" class="btn-action btn-ready" title="Tandai siap disajikan">
                                                    <i class="fas fa-check-circle"></i> Siap
                                                </button>
                                            </form>
                                        @elseif($order->status === 'ready')
                                            <form action="{{ route('kasir.orders.updateStatus', $order) }}" method="POST" style="margin:0;">
                                                @csrf
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn-action btn-completed" title="Tandai selesai">
                                                    <i class="fas fa-flag-checkered"></i> Selesai
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('kasir.orders.show', $order) }}" class="btn-action btn-detail" title="Lihat detail pesanan">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 2rem; color: #999;">
                                    <i class="fas fa-inbox"></i> Tidak ada pesanan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div style="margin-top: 1.5rem; display: flex; justify-content: center;">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Auto-refresh setiap 10 detik
    setTimeout(() => {
        location.reload();
    }, 10000);

    // Reject form modal handler
    function showRejectForm(orderId) {
        const reason = prompt('Masukkan alasan penolakan pesanan:');
        if (reason && reason.trim()) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/kasir/orders/${orderId}/reject`;
            form.innerHTML = `
                @csrf
                <input type="hidden" name="notes" value="${reason.replace(/"/g, '&quot;')}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endsection
