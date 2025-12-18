@extends('layouts.app')

@section('content')
  <h3>Manajemen Margin Penjualan</h3>
  <p class="small-muted">Atur persentase keuntungan toko.</p>

  @if(session('success'))
    <div style="background:#e8f5e9; color:#2e7d32; padding:10px; border-radius:4px; margin-bottom:15px; border:1px solid #c8e6c9;">
        {{ session('success') }}
    </div>
  @endif

  {{-- Filter Bar --}}
  <div style="margin-bottom:15px; padding: 10px; background: #f9f9f9; border: 1px solid #eee; border-radius: 8px; display:flex; align-items: center; gap: 10px;">
    <span style="font-size:14px; color:#666;">Filter Status:</span>
    
    <a href="{{ route('margin.index', ['status' => 'all']) }}" 
       style="text-decoration: none; padding: 5px 10px; border-radius: 4px; font-size: 13px; border: 1px solid #ccc;
       {{ $status === 'all' ? 'background: #333; color: white;' : 'background: white; color: #333;' }}">
       Semua
    </a>

    <a href="{{ route('margin.index', ['status' => '1']) }}" 
       style="text-decoration: none; padding: 5px 10px; border-radius: 4px; font-size: 13px; border: 1px solid #28a745;
       {{ $status == '1' ? 'background: #28a745; color: white;' : 'background: white; color: #28a745;' }}">
       Aktif
    </a>

    <a href="{{ route('margin.index', ['status' => '0']) }}" 
       style="text-decoration: none; padding: 5px 10px; border-radius: 4px; font-size: 13px; border: 1px solid #dc3545;
       {{ $status == '0' ? 'background: #dc3545; color: white;' : 'background: white; color: #dc3545;' }}">
       Non-Aktif
    </a>

    <div style="margin-left:auto;">
        <a href="{{ route('margin.create') }}" style="background:#007bff; color:white; padding:8px 15px; text-decoration:none; border-radius:4px; font-weight:bold;">
          + Tambah Margin
        </a>
    </div>
  </div>

  <table>
    <thead>
      <tr style="background:#eee;">
        <th style="padding:10px;">ID</th>
        <th style="padding:10px;">Persentase</th>
        <th style="padding:10px;">Tgl Dibuat</th>
        <th style="padding:10px;">Dibuat Oleh (User ID)</th>
        <th style="padding:10px;">Status</th>
        <th style="padding:10px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rows as $r)
        <tr style="border-bottom:1px solid #eee; {{ $r->status == 1 ? 'background:#f0fff4;' : '' }}">
          <td style="padding:10px;">{{ $r->idmargin_penjualan }}</td>
          <td style="padding:10px; font-size:1.1em;"><strong>{{ $r->persen }}%</strong></td>
          <td style="padding:10px;">{{ $r->created_at }}</td>
          <td style="padding:10px;">{{ $r->iduser }}</td>
          <td style="padding:10px;">
             @if($r->status == 1)
                <span style="background:#e8f5e9; color:green; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:bold;">AKTIF (Utama)</span>
             @else
                <span style="background:#ffebee; color:red; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:bold;">Non-Aktif</span>
             @endif
          </td>
          <td style="padding:10px;">
            <a href="{{ route('margin.edit', $r->idmargin_penjualan) }}" style="color:blue; text-decoration:underline;">Edit</a>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" style="padding:20px; text-align:center;">Tidak ada data margin.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div style="margin-top:12px">
    {!! $rows->links() !!}
  </div>
@endsection