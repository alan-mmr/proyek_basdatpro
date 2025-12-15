@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Pemilik Baru (Registrasi User)</h6>
        </div>
        <div class="card-body">
            
            {{-- ================================================= --}}
            {{-- BAGIAN 1: MENAMPILKAN ERROR VALIDASI FORM --}}
            {{-- (Contoh: "Nama wajib diisi", "Email format salah") --}}
            {{-- ================================================= --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Perhatian!</strong> Ada masalah dengan inputan Anda:
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error) 
                            <li>{{ $error }}</li> 
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ================================================= --}}
            {{-- BAGIAN 2: MENAMPILKAN ERROR DARI CONTROLLER/DB --}}
            {{-- (Ini yang kemarin kurang. Kalau DB error, muncul disini) --}}
            {{-- ================================================= --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal Menyimpan!</strong> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('admin.pemilik.store') }}" method="POST">
                @csrf
                
                {{-- INFO LOGIN --}}
                <h5 class="text-gray-800 mb-3 border-bottom pb-2">Informasi Akun Login</h5>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nama Lengkap</label>
                        {{-- Gunakan old('name') agar kalau error, isian tidak hilang --}}
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Nama User">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="email@contoh.com">
                    </div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                </div>

                {{-- INFO PROFIL --}}
                <h5 class="text-gray-800 mb-3 mt-4 border-bottom pb-2">Data Alamat & Kontak</h5>
                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control" rows="2" required placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                </div>
                <div class="form-group">
                    <label>No WhatsApp</label>
                    <input type="number" name="no_wa" class="form-control" value="{{ old('no_wa') }}" required placeholder="Contoh: 08123456789">
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="mt-4">
                    <a href="{{ route('admin.pemilik.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan User & Pemilik</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection