@extends('layouts.app')

@section('content')
<div class="container-fluid">
    
    {{-- Judul Halaman --}}
    <h1 class="h3 mb-4 text-gray-800">Manajemen Pemilik Hewan</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pemilik Hewan</h6>
        </div>
        <div class="card-body">
            
            {{-- Tombol Tambah --}}
            <a href="{{ route('admin.pemilik.create') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Tambah Pemilik
            </a>

            {{-- Pesan Sukses --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Pemilik</th> {{-- Kolom ini yang kemarin kosong --}}
                            <th>Alamat</th>
                            <th>No HP/WA</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pemilik as $key => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            
                            {{-- BAGIAN INI YANG KITA PERBAIKI --}}
                            <td>
                                {{-- Kita coba ambil name, kalau gak ada ambil nama, kalau gak ada ambil username --}}
                                <b>{{ $item->user->name ?? $item->user->nama ?? $item->user->username ?? 'User Tidak Ditemukan' }}</b>
                                <br>
                                <small class="text-muted">{{ $item->user->email ?? '-' }}</small>
                            </td>

                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->no_wa }}</td>
                            
                            <td>
                                <a href="{{ route('admin.pemilik.edit', $item->idpemilik) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                
                                <form action="{{ route('admin.pemilik.destroy', $item->idpemilik) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data pemilik.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection