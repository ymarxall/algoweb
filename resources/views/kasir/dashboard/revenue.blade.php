@extends('kasir.layout')

@section('title', 'Laporan Pemasukan - Kasir')
@section('page_title', '💰 Laporan Pemasukan')

@section('content')
<div class="container-fluid">
    {{-- View Selector --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="btn-group" role="group">
                <a href="{{ route('kasir.revenue', ['view' => 'daily']) }}" class="btn btn-{{ $view === 'daily' ? 'primary' : 'outline-primary' }}">Harian (Bulan Ini)</a>
                <a href="{{ route('kasir.revenue', ['view' => 'monthly']) }}" class="btn btn-{{ $view === 'monthly' ? 'primary' : 'outline-primary' }}">Bulanan (Tahun Ini)</a>
            </div>
        </div>
    </div>

    {{-- Stats Summary --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Pemasukan</h5>
                    <p class="card-text h3">Rp {{ number_format($stats['total_revenue'] ?? 0, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Pesanan Selesai</h5>
                    <p class="card-text h3">{{ $stats['total_orders'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Rata-rata per Pesanan</h5>
                    <p class="card-text h3">Rp {{ number_format($stats['avg_order'] ?? 0, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Revenue Breakdown Table --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Rincian Pemasukan {{ $view === 'daily' ? 'Harian' : 'Bulanan' }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ $view === 'daily' ? 'Tanggal' : 'Bulan' }}</th>
                                <th class="text-right">Total Pesanan</th>
                                <th class="text-right">Total Item Terjual</th>
                                <th class="text-right">Total Pemasukan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($revenues as $row)
                                <tr>
                                    <td>
                                        @if ($view === 'daily')
                                            {{ \Carbon\Carbon::parse($row['date'])->format('d M Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($row['date'])->format('F Y') }}
                                        @endif
                                    </td>
                                    <td class="text-right">{{ $row['total_orders'] }}</td>
                                    <td class="text-right">{{ $row['total_items'] }}</td>
                                    <td class="text-right">Rp {{ number_format($row['total_revenue'], 2, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data pemasukan untuk periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Menus & Payment Methods --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Menu Terlaris</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse ($topMenus as $menu)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $menu['name'] }}
                                <span class="badge badge-primary badge-pill">{{ $menu['total_quantity'] }} terjual</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center">Belum ada menu yang terjual.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Metode Pembayaran</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse ($paymentMethods as $method)
                            @if($method['payment_method'])
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ strtoupper($method['payment_method']) }}
                                <div>
                                    <span class="badge badge-info mr-2">{{ $method['total_orders'] }} pesanan</span>
                                    <span class="badge badge-success">Rp {{ number_format($method['total_revenue'], 0, ',', '.') }}</span>
                                </div>
                            </li>
                            @endif
                        @empty
                            <li class="list-group-item text-center">Belum ada transaksi dengan metode pembayaran tercatat.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
