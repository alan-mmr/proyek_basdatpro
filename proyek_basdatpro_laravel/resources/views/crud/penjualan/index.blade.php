@extends('layouts.app')

@section('content')
  <h3>Daftar Transaksi Penjualan</h3>
  <p class="small-muted">List semua transaksi keluar</p>

  @if(session('success'))
    <div style="background:#e8f5e9; color:#2e7d32; padding:10px; border-radius:4px; margin-bottom:15px; border:1px solid #c8e6c9;">
        {{ session('success') }}
    </div>
  @endif

  <div style="margin-bottom:12px; display:flex; gap:12px; align-items:center;">
    <a href="{{ url('/modules/view_penjualan_margin_user') }}" class="card" style="padding:8px 12px;display:inline-block;">
      ← Ringkasan View
    </a>

    <a href="{{ route('penjualan.create') }}" style="margin-left:auto; background:#007bff; color:white; padding:10px 20px; text-decoration:none; border-radius:4px; font-weight:bold;">
      + Buat Transaksi Baru
    </a>
  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Tanggal</th>
        <th>Kasir/User</th>
        <th>Total Nilai</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rows as $r)
        <tr>
          <td>{{ $r->idpenjualan }}</td>
          <td>{{ $r->created_at }}</td>
          <td>{{ $r->nama_kasir ?? '-' }}</td>
          <td style="font-weight:bold;">Rp {{ number_format($r->total_nilai, 0, ',', '.') }}</td>
          <td>
            <a href="{{ route('penjualan.show', $r->idpenjualan) }}" style="color:blue; text-decoration:underline;">Lihat Faktur</a>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" style="text-align:center; padding:20px;">Belum ada transaksi penjualan.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div style="margin-top:12px">
    {!! $rows->links() !!}
  </div>
@endsection