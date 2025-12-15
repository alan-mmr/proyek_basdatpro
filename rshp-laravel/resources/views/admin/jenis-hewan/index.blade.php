@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            {{-- Tampilkan Pesan Sukses/Error --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-header">{{ __('Daftar Jenis Hewan') }}</div>

                <div class="card-body">
                    <a href="{{ route('admin.jenis-hewan.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i> Tambah Jenis Hewan
                    </a>
                    
                    <table class="table table-bordered table-hover mt-3">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Nama Jenis Hewan</th>
                                <th style="width: 20%">Aksi</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jenisHewan as $index => $hewan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $hewan->nama_jenis_hewan }}</td>
                                <td class="text-center">
                                    <form onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');" 
                                          action="{{ route('admin.jenis-hewan.destroy', $hewan->idjenis_hewan) }}" 
                                          method="POST">
                                        
                                        {{-- Tombol EDIT (Kuning) --}}
                                        <a href="{{ route('admin.jenis-hewan.edit', $hewan->idjenis_hewan) }}" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        {{-- Tombol HAPUS (Merah) - Harus pakai CSRF & Method DELETE --}}
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Data masih kosong.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection