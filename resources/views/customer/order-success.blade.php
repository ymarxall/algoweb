<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - Order #{{ $order->id }}</title>
    <!-- Bootstrap CSS (opsional, tambah jika belum di layout) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-success">
                    <div class="card-header bg-success text-white text-center">
                        <h3>✅ Pesanan Berhasil!</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <h5><strong>No. Order:</strong> #{{ $order->id }}</h5>
                                <p><strong>Meja:</strong> {{ $order->table->name ?? 'Tidak diketahui' }}</p>
                                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <h4>Total Harga: <span class="text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></h4>
                                <p><strong>Status Pembayaran:</strong> <span class="badge bg-{{ $order->payment_status == 'pending' ? 'warning' : 'success' }}">{{ ucfirst($order->payment_status) }}</span></p>
                                <p><strong>Status Dapur:</strong> <span class="badge bg-{{ $order->kitchen_status == 'pending' ? 'warning' : ($order->kitchen_status == 'completed' ? 'success' : 'danger') }}">{{ ucfirst($order->kitchen_status) }}</span></p>
                            </div>
                        </div>

                        <hr>

                        <h5>Detail Pesanan:</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Harga Satuan</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($order->menus as $menu)
                                        <tr>
                                            <td>{{ $menu->name }} @if($menu->description) <small class="text-muted">({{ $menu->description }})</small> @endif</td>
                                            <td class="text-center">{{ $menu->pivot->quantity }}</td>
                                            <td class="text-end">Rp {{ number_format($menu->pivot->price, 0, ',', '.') }}</td>
                                            <td class="text-end fw-bold">Rp {{ number_format($menu->pivot->quantity * $menu->pivot->price, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Tidak ada item pesanan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr class="table-success">
                                        <th colspan="3" class="text-end">Total:</th>
                                        <th class="text-end">Rp {{ number_format($order->total_price, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt-4 text-center">
                            <a href="{{ route('menu.table', $order->table_id) }}" class="btn btn-primary me-2">Kembali ke Menu</a>
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">Cart Baru</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (opsional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>