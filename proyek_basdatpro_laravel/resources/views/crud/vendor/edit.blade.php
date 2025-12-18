@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    
    <div style="margin-bottom: 20px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h3 style="margin:0;">Edit Vendor</h3>
            <p class="small-muted" style="margin:5px 0 0;">ID Vendor: #{{ $item->idvendor }}</p>
        </div>
        <a href="{{ route('vendor.index') }}" style="text-decoration:none; color:#666; font-size:14px;">
            ← Kembali
        </a>
    </div>

    <div class="card" style="background:white; padding:25px; border-radius:8px; border:1px solid #eee; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
        <form method="POST" action="{{ route('vendor.update', $item->idvendor) }}">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom:15px;">
                <label style="font-weight:600; font-size:13px; display:block; margin-bottom:5px;">Nama Vendor <span style="color:red">*</span></label>
                <input name="nama_vendor" required value="{{ $item->nama_vendor }}" 
                       style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
            </div>

            <div style="margin-bottom:15px;">
                <label style="font-weight:600; font-size:13px; display:block; margin-bottom:5px;">Badan Hukum <span style="color:red">*</span></label>
                <select name="badan_hukum" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px; background:white;">
                    <option value="P" {{ $item->badan_hukum == 'P' ? 'selected' : '' }}>PT (Perseroan Terbatas)</option>
                    <option value="C" {{ $item->badan_hukum == 'C' ? 'selected' : '' }}>CV (Persekutuan Komanditer)</option>
                    <option value="U" {{ $item->badan_hukum == 'U' ? 'selected' : '' }}>UD (Usaha Dagang)</option>
                    <option value="O" {{ $item->badan_hukum == 'O' ? 'selected' : '' }}>Perorangan</option>
                    <option value="L" {{ $item->badan_hukum == 'L' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div style="margin-bottom:25px;">
                <label style="font-weight:600; font-size:13px; display:block; margin-bottom:5px;">Status</label>
                <select name="status" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px; background:white;">
                    <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>🟢 Aktif</option>
                    <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>🔴 Non-Aktif</option>
                </select>
            </div>

            <div style="border-top:1px solid #eee; padding-top:20px; text-align:right;">
                <a href="{{ route('vendor.index') }}" style="text-decoration:none; color:#555; margin-right:15px; font-size:14px;">Batal</a>
                <button type="submit" style="background:#007bff; color:white; border:none; padding:10px 25px; border-radius:6px; font-weight:600; cursor:pointer;">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection