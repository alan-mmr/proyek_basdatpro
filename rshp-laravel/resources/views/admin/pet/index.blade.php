@extends('layouts.app')

@section('content')
<div class="container-fluid">
    
    <h1 class="h3 mb-4 text-gray-800">Manajemen Hewan Peliharaan (Pet)</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pasien Hewan</h6>
        </div>
        <div class="card-body">
            
            <a href="{{ route('admin.pet.create') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Tambah Hewan Baru
            </a>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Hewan</th>
                            <th>Jenis & Ras</th>
                            <th>Pemilik</th>
                            <th>Info Fisik</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pets as $pet)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            
                            <td>
                                <span class="font-weight-bold text-primary" style="font-size: 1.1em;">
                                    {{ $pet->nama }}
                                </span>
                                <br>
                                @if($pet->jenis_kelamin == 'J')
                                    <span class="badge badge-primary"><i class="fas fa-mars"></i> Jantan</span>
                                @else
                                    <span class="badge badge-danger"><i class="fas fa-venus"></i> Betina</span>
                                @endif
                            </td>

                            <td>
                                <strong>
                                    {{ $pet->ras->jenis->nama_jenis_hewan ?? $pet->ras->jenis->nama ?? 'Jenis?' }}
                                </strong>
                                <br>
                                <small class="text-muted">
                                    Ras: {{ $pet->ras->nama_ras ?? '-' }}
                                </small>
                            </td>

                            <td>
                                <strong>{{ $pet->pemilik->user->nama ?? 'User Hilang' }}</strong>
                                <br>
                                <small>{{ Str::limit($pet->pemilik->alamat ?? '-', 30) }}</small>
                            </td>

                            <td>
                                <div><i class="fas fa-palette text-info"></i> {{ $pet->warna_tanda ?? '-' }}</div>
                                <div><i class="fas fa-birthday-cake text-warning"></i> {{ $pet->tanggal_lahir ?? '-' }}</div>
                            </td>

                            {{-- KOLOM AKSI (UPDATE DISINI) --}}
                            <td>
                                {{-- Tombol Edit (Kuning) --}}
                                <a href="{{ route('admin.pet.edit', $pet->idpet) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                {{-- Tombol Hapus (Merah) --}}
                                <form action="{{ route('admin.pet.destroy', $pet->idpet) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data hewan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center p-4">
                                <span class="text-muted font-italic">Belum ada data hewan peliharaaan.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection