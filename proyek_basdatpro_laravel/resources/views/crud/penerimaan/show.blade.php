@extends('layouts.app')

@section('content')
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
      <div>
          <h3>Detail Penerimaan #{{ $item->idpenerimaan }}</h3>
          {{-- REVISI: Gunakan nama_user (sesuai database saat ini) --}}
          <p class="small-muted">Diterima pada: {{ $item->created_at }} oleh {{ $item->nama_user }}</p>
      </div>
      <div style="text-align:right;">
          <span style="background:#eee; padding:5px 10px; border-radius:4px;">Status: {{ $item->status }}</span>
      </div>
  </div>

  <div class="card" style="margin-bottom:20px; background:#f8f9fa; padding:15px;">
      <strong>Referensi Pengadaan:</strong> <a href="{{ route('pengadaan.show', $item->idpengadaan) }}">PO #{{ $item->idpengadaan }}</a><br>
      <strong>Vendor:</strong> {{ $item->nama_vendor }}<br>
      <strong>Tanggal PO:</strong> {{ $item->tanggal_pengadaan }}
  </div>

  <h4>Barang yang Diterima</h4>
  <table width="100%" style="border-collapse: collapse;">
    <thead>
      <tr style="background:#333; color:white;">
        <th style="padding:10px;">Nama Barang</th>
        <th style="padding:10px;">Jumlah Diterima</th>
        <th style="padding:10px;">Harga Satuan (Locked)</th>
        <th style="padding:10px;">Subtotal Nilai</th>
      </tr>
    </thead>
    <tbody>
      @forelse($details as $d)
        <tr style="border-bottom:1px solid #ddd;">
          <td style="padding:10px;">{{ $d->nama_barang }}</td>
          <td style="padding:10px; font-weight:bold;">{{ $d->jumlah_terima }}</td>
          {{-- Pastikan nama kolom detail juga sesuai view --}}
          <td style="padding:10px;">Rp {{ number_format($d->harga_satuan_terima, 0, ',', '.') }}</td>
          <td style="padding:10px;">Rp {{ number_format($d->sub_total_terima, 0, ',', '.') }}</td>
        </tr>
      @empty
        <tr><td colspan="4" style="text-align:center; padding:20px;">Tidak ada detail barang.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div style="margin-top:20px;">
    <a href="{{ route('penerimaan.index') }}" style="padding:10px 20px; background:#555; color:white; text-decoration:none; border-radius:4px;">Kembali ke Daftar</a>
  </div>
@endsection