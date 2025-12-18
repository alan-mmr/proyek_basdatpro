@extends('layouts.app')
@section('content')
<h3>Tambah Margin Penjualan</h3>
<form method="POST" action="{{ route('margin.store') }}">
    @csrf
    <div style="margin-bottom:15px">
        <label>Persentase Keuntungan (%)</label><br>
        <input type="number" name="persen" step="0.1" required style="padding:8px; width:100px;"> %
    </div>
    <div style="margin-bottom:15px">
        <label>Status</label><br>
        <select name="status" style="padding:8px;">
            <option value="0">Tidak Aktif</option>
            <option value="1">Aktif (Otomatis non-aktifkan yang lain)</option>
        </select>
    </div>
    <button type="submit" style="padding:8px 15px; background:#007bff; color:white; border:none; border-radius:4px;">Simpan</button>
    <a href="{{ route('margin.index') }}" style="margin-left:10px">Batal</a>
</form>
@endsection