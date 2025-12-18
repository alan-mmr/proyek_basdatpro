@extends('layouts.app')

@section('content')
  <h3>Manajemen User (Pengguna)</h3>
  <p class="small-muted">Kelola akun untuk akses sistem.</p>

  @if(session('success'))
    <div style="background:#e8f5e9; color:#2e7d32; padding:10px; border-radius:4px; margin-bottom:15px; border:1px solid #c8e6c9;">
        {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div style="background:#ffebee; color:#c62828; padding:10px; border-radius:4px; margin-bottom:15px; border:1px solid #ef9a9a;">
        {{ session('error') }}
    </div>
  @endif

  {{-- Action Bar --}}
  <div style="margin-bottom:15px; padding: 10px; background: #f9f9f9; border: 1px solid #eee; border-radius: 8px; display:flex; align-items: center; gap: 10px;">
    <a href="{{ url('/modules/view_user_role') }}" style="text-decoration:none; color:#555; font-size:14px;">
        ← Kembali ke Ringkasan
    </a>

    <div style="margin-left:auto; display:flex; gap:10px;">
        <a href="{{ route('role.index') }}" style="background:#6c757d; color:white; padding:8px 15px; text-decoration:none; border-radius:4px; font-size:13px;">
            Kelola Role
        </a>
        <a href="{{ route('user.create') }}" style="background:#007bff; color:white; padding:8px 15px; text-decoration:none; border-radius:4px; font-weight:bold; font-size:13px;">
          + Tambah User
        </a>
    </div>
  </div>

  <table>
    <thead>
      <tr style="background:#eee;">
        <th style="padding:10px;">ID</th>
        <th style="padding:10px;">Username</th>
        <th style="padding:10px;">Role / Jabatan</th>
        <th style="padding:10px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rows as $r)
        <tr style="border-bottom:1px solid #eee;">
          <td style="padding:10px;">{{ $r->iduser }}</td>
          <td style="padding:10px;"><strong>{{ $r->username }}</strong></td>
          <td style="padding:10px;">
              <span style="background:#e3f2fd; color:#0d47a1; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:bold;">
                  {{ $r->nama_role ?? 'Tanpa Role' }}
              </span>
          </td>
          <td style="padding:10px;">
             <a href="{{ route('user.edit', $r->iduser) }}" style="color:blue; text-decoration:underline;">Edit</a>
             
             {{-- Proteksi: Tidak bisa hapus diri sendiri --}}
             @if($r->iduser != session('user.iduser')) 
               | 
               <form method="POST" action="{{ route('user.destroy', $r->iduser) }}" style="display:inline;">
                  @csrf @method('DELETE')
                  <button type="submit" onclick="return confirm('Hapus user {{ $r->username }} secara permanen?')" style="color:red; background:none; border:none; cursor:pointer; text-decoration:underline; padding:0;">Hapus</button>
               </form>
             @endif
          </td>
        </tr>
      @empty
        <tr><td colspan="4" style="padding:20px; text-align:center;">Tidak ada data user.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div style="margin-top:12px">
    {!! $rows->links() !!}
  </div>
@endsection