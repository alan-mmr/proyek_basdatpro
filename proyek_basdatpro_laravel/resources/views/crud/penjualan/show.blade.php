@extends('layouts.app')

@section('content')
<div style="max-width:800px; margin:0 auto;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; border-bottom:2px solid #eee; padding-bottom:10px;">
        <div>
            <h2 style="margin:0;">Faktur Penjualan #{{ $sale->idpenjualan }}</h2>
            <small style="color:#777;">Tanggal: {{ $sale->created_at }}</small>
        </div>
        <div style="text-align:right;">
            <strong>Status: Selesai</strong><br>
            Kasir: {{ $sale->nama_kasir }}
        </div>
    </div>

    {{-- Tabel Barang --}}
    <table width="100%" style="border-collapse: collapse; margin-bottom:20px;">
        <thead>
            <tr style="background:#333; color:white;">
                <th style="padding:10px;">Barang</th>
                <th style="padding:10px; text-align:right;">Harga</th>
                <th style="padding:10px; text-align:center;">Qty</th>
                <th style="padding:10px; text-align:right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $d)
            <tr style="border-bottom:1px solid #ddd;">
                <td style="padding:10px;">{{ $d->nama_barang }}</td>
                <td style="padding:10px; text-align:right;">Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                <td style="padding:10px; text-align:center;">{{ $d->jumlah }}</td>
                <td style="padding:10px; text-align:right;">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="padding:10px; text-align:right; font-weight:bold;">Subtotal</td>
                <td style="padding:10px; text-align:right;">Rp {{ number_format($sale->subtotal_nilai, 0, ',', '.') }}</td>
            </tr>
            <tr>
                {{-- Label disesuaikan dengan Trigger DB (10%) --}}
                <td colspan="3" style="padding:10px; text-align:right; font-weight:bold;">PPN (10%)</td>
                <td style="padding:10px; text-align:right;">Rp {{ number_format($sale->ppn, 0, ',', '.') }}</td>
            </tr>
            <tr style="background:#eee; font-size:1.1em;">
                <td colspan="3" style="padding:10px; text-align:right; font-weight:bold;">TOTAL BAYAR</td>
                <td style="padding:10px; text-align:right; font-weight:bold; color:#c92b2b;">Rp {{ number_format($sale->total_nilai, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="text-align:center; margin-top:30px;">
        <a href="{{ route('penjualan.index') }}" style="padding:10px 20px; background:#555; color:white; text-decoration:none; border-radius:4px;">Kembali ke Daftar</a>
        <button onclick="window.print()" style="padding:10px 20px; background:#007bff; color:white; border:none; border-radius:4px; cursor:pointer; margin-left:10px;">Cetak Faktur</button>
    </div>
</div>
@endsection