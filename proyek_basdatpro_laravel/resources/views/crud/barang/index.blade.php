@extends('layouts.app')

@section('content')
  <h3>Master Barang</h3>
  <p class="small-muted">Kelola data barang dan stok dasar.</p>

  @if(session('success'))
    <div style="background:#e8f5e9; color:#2e7d32; padding:10px; border-radius:4px; margin-bottom:15px; border:1px solid #c8e6c9;">
        {{ session('success') }}
    </div>
  @endif

  {{-- Filter Bar --}}
  <div style="margin-bottom:15px; padding: 10px; background: #f9f9f9; border: 1px solid #eee; border-radius: 8px; display:flex; align-items: center; gap: 10px;">
    <span style="font-size:14px; color:#666;">Filter Status:</span>
    
    <a href="{{ route('barang.index', ['status' => 'all']) }}" 
       style="text-decoration: none; padding: 5px 10px; border-radius: 4px; font-size: 13px; border: 1px solid #ccc;
       {{ $status === 'all' ? 'background: #333; color: white;' : 'background: white; color: #333;' }}">
       Semua
    </a>

    <a href="{{ route('barang.index', ['status' => '1']) }}" 
       style="text-decoration: none; padding: 5px 10px; border-radius: 4px; font-size: 13px; border: 1px solid #28a745;
       {{ $status == '1' ? 'background: #28a745; color: white;' : 'background: white; color: #28a745;' }}">
       Aktif
    </a>

    <a href="{{ route('barang.index', ['status' => '0']) }}" 
       style="text-decoration: none; padding: 5px 10px; border-radius: 4px; font-size: 13px; border: 1px solid #dc3545;
       {{ $status == '0' ? 'background: #dc3545; color: white;' : 'background: white; color: #dc3545;' }}">
       Non-Aktif
    </a>

    <div style="margin-left:auto;">
        <a href="{{ route('barang.create') }}" style="background:#007bff; color:white; padding:8px 15px; text-decoration:none; border-radius:4px; font-weight:bold;">
          + Tambah Barang
        </a>
    </div>
  </div>

  <table>
    <thead>
      <tr style="background:#eee;">
        <th style="padding:10px;">ID</th>
        <th style="padding:10px;">Nama Barang</th>
        <th style="padding:10px;">Jenis</th>
        <th style="padding:10px;">Satuan</th>
        <th style="padding:10px;">Harga Jual</th>
        <th style="padding:10px;">Status</th>
        <th style="padding:10px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rows as $r)
        <tr style="border-bottom:1px solid #eee;">
          <td style="padding:10px;">{{ $r->idbarang }}</td>
          <td style="padding:10px;"><strong>{{ $r->nama }}</strong></td>
          <td style="padding:10px;">{{ $r->jenis }}</td>
          
          {{-- TAMPILKAN NAMA SATUAN --}}
          <td style="padding:10px;">
             {{ $r->nama_satuan ?? ('ID: ' . $r->idsatuan) }}
          </td>

          <td style="padding:10px;">Rp {{ number_format($r->harga, 0, ',', '.') }}</td>
          
          <td style="padding:10px;">
             @if($r->status == 1)
                <span style="background:#e8f5e9; color:green; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:bold;">Aktif</span>
             @else
                <span style="background:#ffebee; color:red; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:bold;">Non-Aktif</span>
             @endif
          </td>
          
          <td style="padding:10px;">
            <a href="{{ route('barang.edit', $r->idbarang) }}" style="color:blue; text-decoration:underline;">Edit</a>
            
            @if(in_array(session('user.nama_role'), ['Super Admin','Superadmin']))
              <form method="POST" action="{{ route('barang.destroy', $r->idbarang) }}" style="display:inline; margin-left:5px;">
                 @csrf @method('DELETE')
                 <button type="submit" onclick="return confirm('Non-aktifkan barang ini?')" style="color:red; background:none; border:none; cursor:pointer; text-decoration:underline; padding:0;">Hapus</button>
              </form>
            @endif
          </td>
        </tr>
      @empty
        <tr><td colspan="7" style="padding:20px; text-align:center;">Tidak ada data barang.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div style="margin-top:12px">
    {!! $rows->links() !!}
  </div>
@endsection