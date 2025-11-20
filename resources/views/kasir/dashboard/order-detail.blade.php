@extends('kasir.layout')

@section('title', 'Detail Pesanan - Kasir')
@section('page_title', '📦 Detail Pesanan: ' . $order->order_number)

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Main Order Info -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-2"><small style="color: #999;">Nomor Pesanan</small></p>
                            <h6 class="mb-3">{{ $order->order_number }}</h6>
                            
                            <p class="mb-2"><small style="color: #999;">Nama Pemesan</small></p>
                            <h6 class="mb-3">{{ $order->customer_name }}</h6>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><small style="color: #999;">Meja</small></p>
                            <h6 class="mb-3">Meja {{ $order->table->table_number ?? '-' }}</h6>
                            
                            <p class="mb-2"><small style="color: #999;">Waktu Pesanan</small></p>
                            <h6 class="mb-3">{{ $order->created_at->format('d M Y H:i') }}</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Items -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Item Pesanan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--primary);">
                                <th>Menu</th>
                                <th style="text-align: right;">Qty</th>
                                <th style="text-align: right;">Harga</th>
                                <th style="text-align: right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->menus as $menu)
                                <tr>
                                    <td>
                                        <strong>{{ $menu->name }}</strong>
                                        @if($menu->pivot->notes)
                                            <div style="font-size: 0.875rem; color: #ff6b35; margin-top: 0.25rem;">
                                                💬 {{ $menu->pivot->notes }}
                                            </div>
                                        @endif
                                    </td>
                                    <td style="text-align: right;">{{ $menu->pivot->quantity }}x</td>
                                    <td style="text-align: right;">Rp{{ number_format($menu->pivot->price, 0, ',', '.') }}</td>
                                    <td style="text-align: right;"><strong>Rp{{ number_format($menu->pivot->quantity * $menu->pivot->price, 0, ',', '.') }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Status History -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Riwayat Status</h5>
                </div>
                <div class="card-body">
                    @forelse($order->statuses->sortByDesc('status_at') as $status)
                        <div style="display: flex; gap: 1rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #eee;">
                            <div style="flex-shrink: 0;">
                                @if($status->status === 'pending')
                                    <span style="display: inline-flex; width: 40px; height: 40px; align-items: center; justify-content: center; background: #fff3cd; border-radius: 50%; color: #ff6b35;">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </span>
                                @elseif($status->status === 'accepted')
                                    <span style="display: inline-flex; width: 40px; height: 40px; align-items: center; justify-content: center; background: #cfe2ff; border-radius: 50%; color: #0d6efd;">
                                        <i class="fas fa-check"></i>
                                    </span>
                                @elseif($status->status === 'preparing')
                                    <span style="display: inline-flex; width: 40px; height: 40px; align-items: center; justify-content: center; background: #e7d5f5; border-radius: 50%; color: #8b5cf6;">
                                        <i class="fas fa-fire"></i>
                                    </span>
                                @else
                                    <span style="display: inline-flex; width: 40px; height: 40px; align-items: center; justify-content: center; background: #d1e7dd; border-radius: 50%; color: #198754;">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                @endif
                            </div>
                            <div style="flex: 1;">
                                <h6 class="mb-1">
                                    @if($status->status === 'pending')
                                        Pesanan Diterima
                                    @elseif($status->status === 'accepted')
                                        Pesanan Diterima Kasir
                                    @elseif($status->status === 'preparing')
                                        Sedang Diproses
                                    @else
                                        Siap Disajikan
                                    @endif
                                </h6>
                                <p class="mb-1" style="font-size: 0.875rem; color: #666;">
                                    {{ $status->status_at->format('d M Y H:i') }}
                                </p>
                                @if($status->notes)
                                    <p class="mb-0" style="font-size: 0.875rem; color: #999;">
                                        Catatan: {{ $status->notes }}
                                    </p>
                                @endif
                                @if($status->changed_by)
                                    <p class="mb-0" style="font-size: 0.75rem; color: #ccc;">
                                        Oleh: {{ $status->user->name }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p style="text-align: center; color: #999;">Belum ada status</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar: Actions -->
        <div class="col-lg-4">
            <!-- Payment Info Card -->
            <div class="card mb-4" style="border: 2px solid var(--primary); background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(255, 140, 97, 0.1));">
                <div class="card-body">
                    <h6 class="mb-3" style="color: var(--primary);">💳 Ringkasan Pembayaran</h6>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ddd;">
                        <span>Subtotal:</span>
                        <strong>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</strong>
                    </div>

                    @if($order->discount > 0)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ddd;">
                            <span style="color: #198754;">Diskon:</span>
                            <strong style="color: #198754;">-Rp{{ number_format($order->discount, 0, ',', '.') }}</strong>
                        </div>
                    @endif

                    @if($order->additional_charges > 0)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #ddd;">
                            <span style="color: #dc3545;">Tambahan:</span>
                            <strong style="color: #dc3545;">+Rp{{ number_format($order->additional_charges, 0, ',', '.') }}</strong>
                        </div>
                    @endif

                    <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem;">
                        <h6 class="mb-0">Total:</h6>
                        <h5 class="mb-0" style="color: var(--primary);">Rp{{ number_format($order->total_price, 0, ',', '.') }}</h5>
                    </div>

                    <hr>

                    <p class="mb-1"><small style="color: #999;">Metode Pembayaran</small></p>
                    <p class="mb-0"><strong>
                        @if($order->payment_method === 'cash') 💵 Tunai @else 💳 Kartu @endif
                    </strong></p>
                </div>
            </div>

            <!-- Status Actions -->
            @if($order->status !== 'completed' && $order->status !== 'rejected' && $order->status !== 'cancelled')
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">⚙️ Ubah Status Pesanan</h6>
                    </div>
                    <div class="card-body">
                        @if($order->status === 'pending')
                            <div style="margin-bottom: 1rem; padding: 0.75rem; background: #f0f7ff; border-radius: 6px; border-left: 4px solid #0d6efd;">
                                <small style="color: #0d6efd;"><i class="fas fa-info-circle"></i> Terima pesanan untuk memulai, atau tolak jika ada masalah</small>
                            </div>
                            <form action="{{ route('kasir.orders.accept', $order) }}" method="POST" style="margin-bottom: 1rem;">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check"></i> ✅ Terima Pesanan
                                </button>
                            </form>
                            <form action="{{ route('kasir.orders.reject', $order) }}" method="POST">
                                @csrf
                                <textarea name="notes" class="form-control form-control-sm mb-2" placeholder="Alasan penolakan..." rows="2" required></textarea>
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-times"></i> ❌ Tolak Pesanan
                                </button>
                            </form>
                        @elseif($order->status === 'accepted')
                            <div style="margin-bottom: 1rem; padding: 0.75rem; background: #fff3cd; border-radius: 6px; border-left: 4px solid #ffc107;">
                                <small style="color: #856404;"><i class="fas fa-info-circle"></i> Masukkan estimasi waktu selesai, lalu mulai proses pesanan</small>
                            </div>
                            <form action="{{ route('kasir.orders.updateStatus', $order) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="preparing">
                                <div class="mb-2">
                                    <label class="form-label mb-1"><small>⏱️ Estimasi Waktu Selesai (Menit)</small></label>
                                    <input type="number" name="estimated_minutes" class="form-control form-control-sm" placeholder="Contoh: 15" value="15" min="1" max="480" required>
                                </div>
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-fire"></i> 🔥 Mulai Proses
                                </button>
                            </form>
                        @elseif($order->status === 'preparing')
                            <div style="margin-bottom: 1rem; padding: 0.75rem; background: #f3e5f5; border-radius: 6px; border-left: 4px solid #8b5cf6;">
                                <small style="color: #5a3a7a;"><i class="fas fa-info-circle"></i> Pesanan sedang diproses. Tandai "Siap Disajikan" ketika sudah selesai disiapkan</small>
                            </div>
                            <form action="{{ route('kasir.orders.updateStatus', $order) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="ready">
                                <button type="submit" class="btn btn-info w-100">
                                    <i class="fas fa-check-circle"></i> ✨ Siap Disajikan
                                </button>
                            </form>
                        @elseif($order->status === 'ready')
                            <div style="margin-bottom: 1rem; padding: 0.75rem; background: #d1e7dd; border-radius: 6px; border-left: 4px solid #198754;">
                                <small style="color: #0f5132;"><i class="fas fa-info-circle"></i> Pesanan siap disajikan ke customer. Tekan "Selesai" setelah diserahkan</small>
                            </div>
                            <form action="{{ route('kasir.orders.updateStatus', $order) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check-double"></i> ✔️ Selesai
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @elseif($order->status === 'rejected')
                <div class="card mb-4" style="border: 2px solid #dc3545; background: #f8d7da;">
                    <div class="card-header" style="background: #f5c6cb; border-bottom: 1px solid #dc3545;">
                        <h6 class="mb-0" style="color: #721c24;">❌ Pesanan Ditolak</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $rejectionHistory = $order->statuses()->where('status', 'rejected')->latest('status_at')->first();
                        @endphp
                        @if($rejectionHistory && $rejectionHistory->notes)
                            <p style="color: #721c24; margin-bottom: 1rem;">
                                <strong>Alasan:</strong> {{ $rejectionHistory->notes }}
                            </p>
                        @endif
                        <a href="{{ route('kasir.orders') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan
                        </a>
                    </div>
                </div>
            @endif

            <!-- Back Button -->
            <a href="{{ route('kasir.orders') }}" class="btn btn-light w-100 mt-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
    }

    .card-header {
        background: #f8f9fa;
        border-radius: 8px 8px 0 0;
        padding: 1rem;
        border-bottom: 1px solid #eee;
    }

    .card-body {
        padding: 1.5rem;
    }

    .btn {
        border: none;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-success {
        background: #198754;
        color: white;
    }

    .btn-success:hover {
        background: #157347;
        color: white;
        text-decoration: none;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
        color: white;
        text-decoration: none;
    }

    .btn-warning {
        background: #ffc107;
        color: #000;
    }

    .btn-warning:hover {
        background: #ffb800;
        color: #000;
        text-decoration: none;
    }

    .btn-info {
        background: #0dcaf0;
        color: #000;
    }

    .btn-info:hover {
        background: #0bb5da;
        color: #000;
        text-decoration: none;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5c636a;
        color: white;
        text-decoration: none;
    }

    .btn-light {
        background: #f8f9fa;
        color: #333;
        border: 1px solid #ddd;
    }

    .btn-light:hover {
        background: #e2e6ea;
        color: #333;
        text-decoration: none;
    }

    .form-control {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
    }

    .form-label {
        font-weight: 500;
        color: #333;
    }
</style>
@endsection
