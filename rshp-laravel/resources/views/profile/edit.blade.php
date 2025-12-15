@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Alert Sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- Alert Error Global --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-circle mr-2"></i> Profil Pengguna</h6>
                </div>
                
                <div class="card-body">
                    {{-- LOGIC DATA (Sama seperti sebelumnya) --}}
                    @php
                        $roleName = $user->roles->first()->nama_role ?? 'User';
                        $isDokter      = stripos($roleName, 'Dokter') !== false;
                        $isPerawat     = stripos($roleName, 'Perawat') !== false;
                        $isResepsionis = stripos($roleName, 'Resepsionis') !== false;
                        $isPemilik     = stripos($roleName, 'Pemilik') !== false;

                        $data = null;
                        if($isDokter)       $data = $dokterData;
                        elseif($isPerawat)  $data = $perawatData;
                        elseif($isResepsionis) $data = $resepsionisData;
                        elseif($isPemilik)  $data = $pemilikData;

                        $alamat = $data->alamat ?? '- Belum diisi -';
                        $no_hp  = $data->no_hp ?? '-';
                        $jk     = $data->jenis_kelamin ?? '-';
                        $bidang = $data->bidang_dokter ?? '-';
                        $pendidikan = $data->pendidikan ?? '-';
                    @endphp

                    {{-- ========================================== --}}
                    {{-- MODE 1: TAMPILAN UTAMA (VIEW ONLY)         --}}
                    {{-- ========================================== --}}
                    <div id="view-mode">
                        {{-- Info Akun --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 text-muted">Nama Lengkap</label>
                            <div class="col-sm-9 font-weight-bold">{{ $user->nama }}</div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 text-muted">Jabatan</label>
                            <div class="col-sm-9"><span class="badge badge-info">{{ $roleName }}</span></div>
                        </div>
                        <hr>
                        {{-- Biodata --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 text-muted">Alamat</label>
                            <div class="col-sm-9">{{ $alamat }}</div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 text-muted">No HP / WhatsApp</label>
                            <div class="col-sm-9">{{ $no_hp }}</div>
                        </div>
                        {{-- Data Spesifik --}}
                        @if($isDokter)
                        <div class="row mb-3">
                            <label class="col-sm-3 text-muted">Bidang Keahlian</label>
                            <div class="col-sm-9">{{ $bidang }}</div>
                        </div>
                        @endif

                        {{-- Tombol Aksi --}}
                        <div class="mt-4 border-top pt-3 d-flex justify-content-between">
                            {{-- Tombol Ganti Password --}}
                            <button type="button" class="btn btn-outline-danger" onclick="switchMode('password')">
                                <i class="fas fa-key mr-1"></i> Ganti Password
                            </button>

                            {{-- Tombol Edit Profil --}}
                            <button type="button" class="btn btn-warning px-4" onclick="switchMode('edit')">
                                <i class="fas fa-pencil-alt mr-1"></i> Ubah Biodata
                            </button>
                        </div>
                    </div>

                    {{-- ========================================== --}}
                    {{-- MODE 2: FORM EDIT BIODATA                  --}}
                    {{-- ========================================== --}}
                    <div id="edit-mode" style="display: none;">
                        <h5 class="text-warning mb-3"><i class="fas fa-pencil-alt mr-2"></i> Edit Biodata</h5>
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('patch')

                            <div class="form-group">
                                <label>Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $data->alamat ?? '') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>No HP / WhatsApp</label>
                                <input type="number" name="no_hp" class="form-control" value="{{ old('no_hp', $data->no_hp ?? '') }}">
                            </div>

                            {{-- Input Khusus Per Role --}}
                            @if($isDokter || $isPerawat)
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="L" {{ ($jk == 'L') ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ ($jk == 'P') ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            @endif

                            @if($isDokter)
                            <div class="form-group">
                                <label>Bidang Keahlian</label>
                                <input type="text" name="bidang_dokter" class="form-control" value="{{ old('bidang_dokter', $data->bidang_dokter ?? '') }}">
                            </div>
                            @endif
                             @if($isPerawat)
                            <div class="form-group">
                                <label>Pendidikan</label>
                                <input type="text" name="pendidikan" class="form-control" value="{{ old('pendidikan', $data->pendidikan ?? '') }}">
                            </div>
                            @endif

                            <div class="mt-4 text-right">
                                <button type="button" class="btn btn-secondary mr-2" onclick="switchMode('view')">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>

                    {{-- ========================================== --}}
                    {{-- MODE 3: FORM GANTI PASSWORD                --}}
                    {{-- ========================================== --}}
                    <div id="password-mode" style="display: none;">
                        <h5 class="text-danger mb-3"><i class="fas fa-lock mr-2"></i> Ganti Password</h5>
                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            @method('patch')

                            <div class="form-group">
                                <label>Password Saat Ini</label>
                                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Masukkan password lama">
                                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <hr>

                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                            </div>

                            <div class="mt-4 text-right">
                                <button type="button" class="btn btn-secondary mr-2" onclick="switchMode('view')">Batal</button>
                                <button type="submit" class="btn btn-danger">Ganti Password</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function switchMode(mode) {
        // Sembunyikan semua mode dulu
        document.getElementById('view-mode').style.display = 'none';
        document.getElementById('edit-mode').style.display = 'none';
        document.getElementById('password-mode').style.display = 'none';

        // Tampilkan mode yang dipilih
        if (mode === 'view') {
            document.getElementById('view-mode').style.display = 'block';
        } else if (mode === 'edit') {
            document.getElementById('edit-mode').style.display = 'block';
        } else if (mode === 'password') {
            document.getElementById('password-mode').style.display = 'block';
        }
    }

    // Auto open mode jika ada error validasi
    @if ($errors->has('current_password') || $errors->has('password'))
        switchMode('password');
    @elseif ($errors->any())
        switchMode('edit');
    @endif
</script>
@endsection