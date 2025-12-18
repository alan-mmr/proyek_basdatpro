@extends('layouts.app')

@section('content')
  <h3>Riwayat Penerimaan Barang</h3>
  <p class="small-muted">Daftar barang masuk (Inbound) dari Vendor.</p>

  @if(session('success'))
    <div style="background:#e8f5e9; color:#2e7d32; padding:10px; border-radius:4px; margin-bottom:15px; border:1px solid #c8e6c9;">
        {{ session('success') }}
    </div>
  @endif

  <div style="margin-bottom:12px; display:flex; gap:12px; align-items:center;">
    <a href="{{ url('/modules/view_penerimaan_pengadaan_user') }}" class="card" style="padding:8px 12px;display:inline-block;">
      ← Ringkasan View
    </a>

    <a href="{{ route('penerimaan.create') }}" style="margin-left:auto; background:#007bff; color:white; padding:10px 20px; text-decoration:none; border-radius:4px; font-weight:bold;">
      + Input Penerimaan Baru
    </a>
  </div>

  <table>
    <thead>
      <tr>
        <th>ID Penerimaan</th>
        <th>Tanggal Terima</th>
        <th>Ref. Pengadaan</th>
        <th>Vendor</th>
        <th>Penerima (User)</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rows as $r)
        <tr>
          <td>{{ $r->idpenerimaan }}</td>
          <td>{{ $r->created_at }}</td>
          <td>PO #{{ $r->idpengadaan }}</td>
          <td>{{ $r->nama_vendor }}</td>
          {{-- Pastikan nama kolom sesuai view database --}}
          <td>{{ $r->nama_user ?? $r->nama_user_penerima ?? '-' }}</td>
          <td>
            <a href="{{ route('penerimaan.show', $r->idpenerimaan) }}" style="color:blue; text-decoration:underline;">Detail</a>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center; padding:20px;">Belum ada data penerimaan.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div style="margin-top:12px">
    {!! $rows->links() !!}
  </div>
@endsection