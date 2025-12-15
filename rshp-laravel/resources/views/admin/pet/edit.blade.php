@extends('layouts.app')

@section('content')
<div class="container-fluid">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Data Hewan</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Pasien Hewan</h6>
        </div>
        <div class="card-body">
            
            {{-- ERROR HANDLING --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.pet.update', $pet->idpet) }}" method="POST">
                @csrf
                @method('PUT') {{-- WAJIB: Ubah method jadi PUT untuk Update --}}
                
                {{-- BARIS 1 --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nama Hewan <span class="text-danger">*</span></label>
                        {{-- Isi value dengan data lama ($pet->nama) --}}
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $pet->nama) }}" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Pemilik <span class="text-danger">*</span></label>
                        <select name="idpemilik" class="form-control select2" required>
                            <option value="">-- Cari Pemilik --</option>
                            @foreach($pemiliks as $p)
                                <option value="{{ $p->idpemilik }}" 
                                    {{-- Cek: Jika ID Pemilik sama dengan data lama, maka SELECTED --}}
                                    {{ old('idpemilik', $pet->idpemilik) == $p->idpemilik ? 'selected' : '' }}>
                                    {{ $p->user->nama ?? $p->user->name ?? 'User Hapus' }} ({{ Str::limit($p->alamat, 20) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- BARIS 2 --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Jenis & Ras Hewan <span class="text-danger">*</span></label>
                        <select name="idras_hewan" class="form-control select2" required>
                            <option value="">-- Pilih Jenis/Ras --</option>
                            @foreach($ras_hewans as $r)
                                <option value="{{ $r->idras_hewan }}" 
                                    {{-- Cek Selected --}}
                                    {{ old('idras_hewan', $pet->idras_hewan) == $r->idras_hewan ? 'selected' : '' }}>
                                    {{ $r->jenis->nama_jenis_hewan ?? $r->jenis->nama ?? 'Jenis?' }} - {{ $r->nama_ras }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="J" {{ old('jenis_kelamin', $pet->jenis_kelamin) == 'J' ? 'selected' : '' }}>Jantan</option>
                            <option value="B" {{ old('jenis_kelamin', $pet->jenis_kelamin) == 'B' ? 'selected' : '' }}>Betina</option>
                        </select>
                    </div>
                </div>

                {{-- BARIS 3 --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Warna / Ciri Khusus</label>
                        <input type="text" name="warna_tanda" class="form-control" value="{{ old('warna_tanda', $pet->warna_tanda) }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $pet->tanggal_lahir) }}">
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.pet.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection