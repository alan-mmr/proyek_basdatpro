@extends('layouts.app')

@section('content')
    <div style="margin-bottom: 25px;">
        <h2 style="margin:0;">Dashboard Utama</h2>
        <p class="small-muted">
            Selamat datang, <strong>{{ session('user.username') }}</strong>. 
            Anda login sebagai <span style="background:#eee; padding:2px 6px; border-radius:4px;">{{ $role }}</span>.
        </p>
    </div>

    {{-- Kartu Ringkasan (Statistik) --}}
    <div style="display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap;">
        
        <div class="card" style="flex: 1; min-width: 200px; background: #e3f2fd; border: 1px solid #bbdefb;">
            <h4 style="margin: 0 0 10px 0; color: #1565c0;">Total Omset Penjualan</h4>
            <div style="font-size: 24px; font-weight: bold; color: #0d47a1;">
                Rp {{ number_format($totalOmset, 0, ',', '.') }}
            </div>
            <small style="color: #555;">Uang masuk dari customer</small>
        </div>

        <div class="card" style="flex: 1; min-width: 200px; background: #ffebee; border: 1px solid #ffcdd2;">
            <h4 style="margin: 0 0 10px 0; color: #c62828;">Total Belanja (PO)</h4>
            <div style="font-size: 24px; font-weight: bold; color: #b71c1c;">
                Rp {{ number_format($totalPengadaan, 0, ',', '.') }}
            </div>
            <small style="color: #555;">Uang keluar ke vendor</small>
        </div>

        <div class="card" style="flex: 1; min-width: 200px; background: #f3e5f5; border: 1px solid #e1bee7;">
            <h4 style="margin: 0 0 10px 0; color: #6a1b9a;">Jumlah Transaksi</h4>
            <div style="font-size: 24px; font-weight: bold; color: #4a148c;">
                {{ number_format($totalPenjualan) }}
            </div>
            <small style="color: #555;">Kali penjualan berhasil</small>
        </div>

    </div>

    {{-- Tabel Minat Pasar --}}
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
            <h3 style="margin:0;">🔥 Top 5 Barang Terlaris (Minat Pasar)</h3>
            <small>Data diambil dari Stored Procedure <code>sp_minat_pasar</code></small>
        </div>

        <table width="100%" style="border-collapse: collapse;">
            <thead>
                <tr style="background: #f9f9f9; text-align: left; border-bottom: 2px solid #eee;">
                    <th style="padding: 12px;">Nama Barang</th>
                    <th style="padding: 12px; text-align: center;">Jumlah Terjual</th>
                    <th style="padding: 12px; text-align: center;">Stok Tersisa</th>
                    <th style="padding: 12px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($top5 as $item)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px; font-weight: 500;">{{ $item->nama_barang }}</td>
                        
                        {{--  SP minat pasar --}}
                        <td style="padding: 12px; text-align: center; font-size: 1.1em; color: #2e7d32; font-weight: bold;">
                            {{ $item->jumlah_terjual }} 
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            {{ $item->stock_tersisa }}
                        </td>

                        <td style="padding: 12px;">
                            @if($item->stock_tersisa <= 5)
                                <span style="color: red; font-weight: bold; font-size: 0.85em; background: #ffebee; padding: 3px 8px; border-radius: 10px;">Menipis!</span>
                            @else
                                <span style="color: green; font-weight: bold; font-size: 0.85em; background: #e8f5e9; padding: 3px 8px; border-radius: 10px;">Aman</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 20px; text-align: center; color: #777;">
                            Belum ada data transaksi penjualan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection