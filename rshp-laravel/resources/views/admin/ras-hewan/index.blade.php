@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Daftar Ras Hewan</div>
        <div class="card-body">
            <a href="{{ route('admin.ras-hewan.create') }}" class="btn btn-primary mb-3">Tambah Ras Hewan</a>
            
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Ras</th>
                        <th>Jenis Hewan (Induk)</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rasHewan as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data->nama_ras }}</td>
                        <td>
                            {{-- Mengambil Nama Jenis dari Relasi --}}
                            {{ $data->jenisHewan->nama_jenis_hewan ?? '-' }}
                        </td>
                        <td class="text-center">
                            <form onsubmit="return confirm('Hapus data ini?');" 
                                  action="{{ route('admin.ras-hewan.destroy', $data->idras_hewan) }}" method="POST">
                                <a href="{{ route('admin.ras-hewan.edit', $data->idras_hewan) }}" class="btn btn-warning btn-sm">Edit</a>
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">Data kosong.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection