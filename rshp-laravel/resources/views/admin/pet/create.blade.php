@extends('layouts.app')

@section('content')
<div class="container-fluid">
    
    {{-- JUDUL HALAMAN --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Hewan Baru</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Pasien Hewan</h6>
        </div>
        <div class="card-body">
            
            {{-- CEK ERROR DARI DATABASE / CONTROLLER --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal!</strong> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- CEK ERROR VALIDASI INPUT --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Perhatian!</strong> Ada data yang belum sesuai:
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error) 
                            <li>{{ $error }}</li> 
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.pet.store') }}" method="POST">
                @csrf
                
                {{-- ==================================================== --}}
                {{-- BAGIAN 1: IDENTITAS UTAMA --}}
                {{-- ==================================================== --}}
                <div class="form-row">
                    {{-- Input Nama Hewan --}}
                    <div class="form-group col-md-6">
                        <label>Nama Hewan <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required placeholder="Contoh: Mochi">
                    </div>

                    {{-- Dropdown Pilih Pemilik --}}
                    <div class="form-group col-md-6">
                        <label>Pemilik <span class="text-danger">*</span></label>
                        <select name="idpemilik" class="form-control select2" required>
                            <option value="">-- Cari Pemilik --</option>
                            @foreach($pemiliks as $p)
                                <option value="{{ $p->idpemilik }}" {{ old('idpemilik') == $p->idpemilik ? 'selected' : '' }}>
                                    {{-- Menampilkan: Nama User (Alamat Singkat) --}}
                                    {{ $p->user->nama ?? $p->user->name ?? 'User Hapus' }} ({{ Str::limit($p->alamat, 20) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- ==================================================== --}}
                {{-- BAGIAN 2: KLASIFIKASI HEWAN --}}
                {{-- ==================================================== --}}
                <div class="form-row">
                    {{-- Dropdown Pilih Ras (PERBAIKAN UTAMA DISINI) --}}
                    <div class="form-group col-md-6">
                        <label>Jenis & Ras Hewan <span class="text-danger">*</span></label>
                        <select name="idras_hewan" class="form-control select2" required>
                            <option value="">-- Pilih Jenis/Ras --</option>
                            @foreach($ras_hewans as $r)
                                <option value="{{ $r->idras_hewan }}" {{ old('idras_hewan') == $r->idras_hewan ? 'selected' : '' }}>
                                    {{-- FORMAT: [JENIS] - [NAMA RAS] --}}
                                    {{-- Kita panggil relasi 'jenis' lalu ambil namanya. Kalau null, tampilkan 'Jenis?' --}}
                                    {{ $r->jenis->nama_jenis_hewan ?? $r->jenis->nama ?? 'Jenis?' }} 
                                    - 
                                    {{-- Panggil 'nama_ras' sesuai database --}}
                                    {{ $r->nama_ras }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Dropdown Jenis Kelamin --}}
                    <div class="form-group col-md-6">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="J" {{ old('jenis_kelamin') == 'J' ? 'selected' : '' }}>Jantan</option>
                            <option value="B" {{ old('jenis_kelamin') == 'B' ? 'selected' : '' }}>Betina</option>
                        </select>
                    </div>
                </div>

                {{-- ==================================================== --}}
                {{-- BAGIAN 3: CIRI FISIK --}}
                {{-- ==================================================== --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Warna / Ciri Khusus</label>
                        <input type="text" name="warna_tanda" class="form-control" value="{{ old('warna_tanda') }}" placeholder="Contoh: Putih Belang Hitam">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tanggal Lahir (Perkiraan)</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                        <small class="text-muted">Kosongkan jika tidak tahu.</small>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.pet.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Data Hewan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection