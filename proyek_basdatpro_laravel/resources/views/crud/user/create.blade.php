@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    
    <div style="margin-bottom: 20px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h3 style="margin:0;">Tambah User Baru</h3>
            <p class="small-muted" style="margin:5px 0 0;">Buat akun login untuk pegawai.</p>
        </div>
        <a href="{{ route('user.index') }}" style="text-decoration:none; color:#666; font-size:14px;">
            ← Kembali
        </a>
    </div>

    <div class="card" style="background:white; padding:25px; border-radius:8px; border:1px solid #eee; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
        <form method="POST" action="{{ route('user.store') }}">
            @csrf
            
            <div style="margin-bottom:15px;">
                <label style="font-weight:600; font-size:13px; display:block; margin-bottom:5px;">Username <span style="color:red">*</span></label>
                <input name="username" required value="{{ old('username') }}" placeholder="Contoh: kasir01" 
                       style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
            </div>

            <div style="margin-bottom:15px;">
                <label style="font-weight:600; font-size:13px; display:block; margin-bottom:5px;">Password <span style="color:red">*</span></label>
                <input type="password" name="password" required placeholder="Minimal 3 karakter"
                       style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
            </div>

            <div style="margin-bottom:25px;">
                <label style="font-weight:600; font-size:13px; display:block; margin-bottom:5px;">Jabatan / Role <span style="color:red">*</span></label>
                <select name="idrole" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px; background:white;">
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->idrole }}">{{ $role->nama_role }}</option>
                    @endforeach
                </select>
            </div>

            <div style="border-top:1px solid #eee; padding-top:20px; text-align:right;">
                <a href="{{ route('user.index') }}" style="text-decoration:none; color:#555; margin-right:15px; font-size:14px;">Batal</a>
                <button type="submit" style="background:#007bff; color:white; border:none; padding:10px 25px; border-radius:6px; font-weight:600; cursor:pointer;">
                    Buat Akun
                </button>
            </div>

        </form>
    </div>
</div>
@endsection