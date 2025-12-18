@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    
    <div style="margin-bottom: 20px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h3 style="margin:0;">Edit Barang: {{ $item->nama }}</h3>
            <p class="small-muted" style="margin:5px 0 0;">ID Barang: #{{ $item->idbarang }}</p>
        </div>
        <a href="{{ route('barang.index') }}" style="text-decoration:none; color:#666; font-size:14px;">
            ← Kembali
        </a>
    </div>

    <div class="card" style="background:white; padding:25px; border-radius:8px; border:1px solid #eee; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
        <form method="POST" action="{{ route('barang.update', $item->idbarang) }}">
            @csrf
            @method('PUT')
            
            {{-- Baris 1: Nama & Jenis --}}
            <div style="display:flex; gap:20px; margin-bottom:15px;">
                <div style="flex:1;">
                    <label style="font-weight:600; font-size:13px; display:block; margin-bottom:5px;">Nama Barang <span style="color:red">*</span></label>
                    <input name="nama" required value="{{ $item->nama }}" 
                           style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                </div>
                <div style="width:150px;">
                    <label style="font-weight:600; font-size:13px; display:block; margin-bottom:5px;">Jenis (Kode) <span style="color:red">*</span></label>
                    <input name="jenis" required value="{{ $item->jenis }}" maxlength="1" 
                           style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px; text-align:center; text-transform:uppercase;">
                </div>
            </div>

            {{-- Baris 2: Satuan & Harga --}}
            <div style="display:flex; gap:20px; margin-bottom:15px;">
                <div style="flex:1;">
                    <label style="font-weight:600; font-size:13px; display:block; margin-bottom:5px;">Satuan <span style="color:red">*</span></label>
                    <select name="idsatuan" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px; background:white;">
                        @foreach($satuan as $s)
                            <option value="{{ $s->idsatuan }}" {{ $s->idsatuan == $item->idsatuan ? 'selected' : '' }}>
                                {{ $s->nama_satuan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="flex:1;">
                    <label style="font-weight:600; font-size:13px; display:block; margin-bottom:5px;">Harga Jual (Rp)</label>
                    <input type="number" name="harga" value="{{ $item->harga }}" min="0"
                           style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                </div>
            </div>

            {{-- Baris 3: Status --}}
            <div style="margin-bottom:25px;">
                <label style="font-weight:600; font-size:13px; display:block; margin-bottom:5px;">Status Barang</label>
                <select name="status" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px; background:white;">
                    <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>🟢 Aktif</option>
                    <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>🔴 Non-Aktif (Arsip)</option>
                </select>
            </div>

            {{-- Tombol Aksi --}}
            <div style="border-top:1px solid #eee; padding-top:20px; text-align:right;">
                <a href="{{ route('barang.index') }}" style="text-decoration:none; color:#555; margin-right:15px; font-size:14px;">Batal</a>
                <button type="submit" style="background:#007bff; color:white; border:none; padding:10px 25px; border-radius:6px; font-weight:600; cursor:pointer;">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection