@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data Pemilik</h6>
        </div>
        <div class="card-body">
            
            {{-- Tampilkan Error jika update gagal --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('admin.pemilik.update', $pemilik->idpemilik) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- INFO USER (READONLY) --}}
                <div class="form-group">
                    <label>Nama Pemilik (User)</label>
                    {{-- PERBAIKAN DI SINI: Panggil 'nama' dulu, baru 'name' --}}
                    <input type="text" class="form-control" 
                        value="{{ $pemilik->user->nama ?? $pemilik->user->name ?? 'User Tidak Ditemukan' }}" 
                        disabled>
                    <small class="text-muted">Nama dan Email diedit melalui menu Manajemen User.</small>
                </div>

                {{-- FORM EDIT ALAMAT --}}
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $pemilik->alamat) }}</textarea>
                </div>

                {{-- FORM EDIT WA --}}
                <div class="form-group">
                    <label>No WhatsApp (WA)</label>
                    <input type="number" name="no_wa" class="form-control" value="{{ old('no_wa', $pemilik->no_wa) }}" required>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.pemilik.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection