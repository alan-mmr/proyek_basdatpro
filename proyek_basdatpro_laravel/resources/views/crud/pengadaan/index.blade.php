@extends('layouts.app')

@section('content')
  <h3>Riwayat Pengadaan (PO)</h3>
  <p class="small-muted">Daftar pesanan barang ke Vendor.</p>

  @if(session('success'))
    <div style="background:#e8f5e9; color:#2e7d32; padding:10px; border-radius:4px; margin-bottom:15px; border:1px solid #c8e6c9;">
        {{ session('success') }}
    </div>
  @endif

  <div style="margin-bottom:15px; padding: 10px; background: #f9f9f9; border: 1px solid #eee; border-radius: 8px; display:flex; align-items: center;">
    {{-- Link Ringkasan --}}
    <a href="{{ url('/modules/view_pengadaan_vendor_user') }}" style="text-decoration:none; color:#555; font-size:14px;">
        ← Lihat Ringkasan View
    </a>

    <div style="margin-left:auto;">
        <a href="{{ route('pengadaan.create') }}" style="background:#007bff; color:white; padding:8px 15px; text-decoration:none; border-radius:4px; font-weight:bold; font-size:13px;">
          + Buat PO Baru
        </a>
    </div>
  </div>

  <table>
    <thead>
      <tr style="background:#eee;">
        <th style="padding:10px;">No. PO</th>
        <th style="padding:10px;">Tanggal</th>
        <th style="padding:10px;">Vendor</th>
        <th style="padding:10px;">Pembuat (User)</th>
        <th style="padding:10px;">Total Nilai</th>
        <th style="padding:10px;">Status</th>
        <th style="padding:10px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rows as $r)
        <tr style="border-bottom:1px solid #eee;">
          <td style="padding:10px;"><strong>#{{ $r->idpengadaan }}</strong></td>
          <td style="padding:10px;">{{ $r->timestamp }}</td>
          <td style="padding:10px;">{{ $r->nama_vendor }}</td>
          <td style="padding:10px;">{{ $r->nama_user }}</td>
          <td style="padding:10px;">Rp {{ number_format($r->total_nilai, 0, ',', '.') }}</td>
          <td style="padding:10px;">
             @if($r->status == '1')
                <span style="background:#e8f5e9; color:green; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:bold;">Selesai</span>
             @else
                <span style="background:#fff3cd; color:#856404; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:bold;">Proses</span>
             @endif
          </td>
          <td style="padding:10px;">
            <a href="{{ route('pengadaan.show', $r->idpengadaan) }}" style="color:blue; text-decoration:underline;">Detail</a>
          </td>
        </tr>
      @empty
        <tr><td colspan="7" style="padding:20px; text-align:center;">Belum ada data pengadaan.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div style="margin-top:12px">
    {!! $rows->links() !!}
  </div>
@endsection 