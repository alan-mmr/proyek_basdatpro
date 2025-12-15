@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card col-md-8 mx-auto">
        <div class="card-header">Edit Ras Hewan</div>
        <div class="card-body">
            <form action="{{ route('admin.ras-hewan.update', $rasHewan->idras_hewan) }}" method="POST">
                @csrf @method('PUT')
                
                {{-- Dropdown Jenis Hewan --}}
                <div class="form-group mb-3">
                    <label>Jenis Hewan</label>
                    <select name="idjenis_hewan" class="form-control" required>
                        <option value="">-- Pilih Jenis Hewan --</option>
                        @foreach($jenisHewan as $jenis)
                            <option value="{{ $jenis->idjenis_hewan }}" 
                                {{ $rasHewan->idjenis_hewan == $jenis->idjenis_hewan ? 'selected' : '' }}>
                                {{ $jenis->nama_jenis_hewan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Input Nama Ras --}}
                <div class="form-group mb-3">
                    <label>Nama Ras</label>
                    <input type="text" name="nama_ras" class="form-control" 
                           value="{{ $rasHewan->nama_ras }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.ras-hewan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection