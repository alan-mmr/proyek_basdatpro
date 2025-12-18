@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    
    <div style="margin-bottom: 20px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h3 style="margin:0;">Tambah Role Baru</h3>
            <p class="small-muted" style="margin:5px 0 0;">Buat jabatan baru untuk pengguna.</p>
        </div>
        <a href="{{ route('role.index') }}" style="text-decoration:none; color:#666; font-size:14px;">
            ← Kembali
        </a>
    </div>

    <div class="card" style="background:white; padding:25px; border-radius:8px; border:1px solid #eee; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
        <form method="POST" action="{{ route('role.store') }}">
            @csrf
            
            <div style="margin-bottom:25px;">
                <label style="font-weight:600; font-size:13px; display:block; margin-bottom:5px;">Nama Role / Jabatan <span style="color:red">*</span></label>
                <input name="nama_role" required value="{{ old('nama_role') }}" placeholder="Contoh: Supervisor" 
                       style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
            </div>

            <div style="border-top:1px solid #eee; padding-top:20px; text-align:right;">
                <a href="{{ route('role.index') }}" style="text-decoration:none; color:#555; margin-right:15px; font-size:14px;">Batal</a>
                <button type="submit" style="background:#007bff; color:white; border:none; padding:10px 25px; border-radius:6px; font-weight:600; cursor:pointer;">
                    Simpan Data
                </button>
            </div>

        </form>
    </div>
</div>
@endsection