@extends('layouts.app')

@section('content')
  <h3>Manajemen Role & Jabatan</h3>
  <p class="small-muted">Atur hak akses dan jabatan pengguna.</p>

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
        <a href="{{ route('user.index') }}" style="background:#6c757d; color:white; padding:8px 15px; text-decoration:none; border-radius:4px; font-size:13px;">
            Kelola User
        </a>
        <a href="{{ route('role.create') }}" style="background:#007bff; color:white; padding:8px 15px; text-decoration:none; border-radius:4px; font-weight:bold; font-size:13px;">
          + Tambah Role
        </a>
    </div>
  </div>

  <table>
    <thead>
      <tr style="background:#eee;">
        <th style="padding:10px;">ID</th>
        <th style="padding:10px;">Nama Role</th>
        <th style="padding:10px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rows as $r)
        <tr style="border-bottom:1px solid #eee;">
          <td style="padding:10px;">{{ $r->idrole }}</td>
          <td style="padding:10px;"><strong>{{ $r->nama_role }}</strong></td>
          <td style="padding:10px;">
             <a href="{{ route('role.edit', $r->idrole) }}" style="color:blue; text-decoration:underline;">Edit</a>
             
             {{-- Role ID 1-5 (Bawaan) Tidak boleh dihapus --}}
             @if($r->idrole > 5)
               | 
               <form method="POST" action="{{ route('role.destroy', $r->idrole) }}" style="display:inline;">
                  @csrf @method('DELETE')
                  <button type="submit" onclick="return confirm('Hapus role ini secara permanen?')" style="color:red; background:none; border:none; cursor:pointer; text-decoration:underline; padding:0;">Hapus</button>
               </form>
             @else
               <span style="color:#999; font-size:11px; margin-left:5px;">(System)</span>
             @endif
          </td>
        </tr>
      @empty
        <tr><td colspan="3" style="padding:20px; text-align:center;">Tidak ada data.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div style="margin-top:12px">
    {!! $rows->links() !!}
  </div>
@endsection