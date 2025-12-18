@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    
    <div style="margin-bottom: 20px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h3 style="margin:0;">Edit User: {{ $item->username }}</h3>
            <p class="small-muted" style="margin:5px 0 0;">ID User: #{{ $item->iduser }}</p>
        </div>
        <a href="{{ route('user.index') }}" style="text-decoration:none; color:#666; font-size:14px;">
            ← Kembali
        </a>
    </div>

    <div class="card" style="background:white; padding:25px; border-radius:8px; border:1px solid #eee; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
        <form method="POST" action="{{ route('user.update', $item->iduser) }}">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom:15px;">
                <label style="font-weight:600; font-size:13px; display:block; margin-bottom:5px;">Username</label>
                <input name="username" required value="{{ $item->username }}" 
                       style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
            </div>

            <div style="margin-bottom:15px;">
                <label style="font-weight:600; font-size:13px; display:block; margin-bottom:5px;">Password Baru (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password"
                       style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                <p class="small-muted" style="margin:3px 0 0; color:#888; font-size:11px;">Isi hanya jika ingin mengganti password user ini.</p>
            </div>

            <div style="margin-bottom:25px;">
                <label style="font-weight:600; font-size:13px; display:block; margin-bottom:5px;">Jabatan / Role</label>
                <select name="idrole" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px; background:white;">
                    @foreach($roles as $role)
                        <option value="{{ $role->idrole }}" {{ $item->idrole == $role->idrole ? 'selected' : '' }}>
                            {{ $role->nama_role }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="border-top:1px solid #eee; padding-top:20px; text-align:right;">
                <a href="{{ route('user.index') }}" style="text-decoration:none; color:#555; margin-right:15px; font-size:14px;">Batal</a>
                <button type="submit" style="background:#007bff; color:white; border:none; padding:10px 25px; border-radius:6px; font-weight:600; cursor:pointer;">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection