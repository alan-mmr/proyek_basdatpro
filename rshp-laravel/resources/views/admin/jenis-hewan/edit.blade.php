@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Jenis Hewan</div>

                <div class="card-body">
                    {{-- Perhatikan Action route-nya mengarah ke UPDATE --}}
                    <form action="{{ route('admin.jenis-hewan.update', $jenisHewan->idjenis_hewan) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Wajib pakai PUT untuk update --}}

                        <div class="form-group mb-3">
                            <label>Nama Jenis Hewan</label>
                            {{-- Value diambil dari database ($jenisHewan->nama...) --}}
                            <input type="text" name="nama_jenis_hewan" 
                                   class="form-control @error('nama_jenis_hewan') is-invalid @enderror"
                                   value="{{ old('nama_jenis_hewan', $jenisHewan->nama_jenis_hewan) }}">
                            
                            @error('nama_jenis_hewan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('admin.jenis-hewan.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection