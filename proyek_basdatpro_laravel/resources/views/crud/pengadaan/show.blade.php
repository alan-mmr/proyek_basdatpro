@extends('layouts.app')

@section('content')
  <h3>Detail Pengadaan — ID: {{ data_get($item,'idpengadaan','') }}</h3>
  <p class="small-muted">Vendor: {{ data_get($item,'nama_vendor','') }} — Dibuat oleh user id: {{ data_get($item,'iduser','') }}</p>

  <div class="card" style="margin-bottom:12px">
    <table>
      <tr><th>Waktu</th><td>{{ data_get($item,'timestamp','') }}</td></tr>
      <tr><th>Subtotal</th><td>{{ data_get($item,'subtotal_nilai','') }}</td></tr>
      <tr><th>PPN</th><td>{{ data_get($item,'ppn','') }}</td></tr>
      <tr><th>Total</th><td>{{ data_get($item,'total_nilai','') }}</td></tr>
      <tr><th>Status</th><td>{{ data_get($item,'status','') }}</td></tr>
    </table>
  </div>

  <h4>Detail Barang (detail_pengadaan)</h4>
  <table>
    <thead><tr><th>idetail_pengadaan</th><th>idbarang</th><th>jumlah</th><th>harga_satuan</th><th>subtotal</th></tr></thead>
    <tbody>
      @forelse($details as $d)
        <tr>
          <td>{{ data_get($d,'iddetail_pengadaan','') }}</td>
          <td>{{ data_get($d,'idbarang','') }}</td>
          <td>{{ data_get($d,'jumlah','') }}</td>
          <td>{{ data_get($d,'harga_satuan','') }}</td>
          <td>{{ data_get($d,'sub_total','') }}</td>
        </tr>
      @empty
        <tr><td colspan="5">Belum ada detail penerimaan/pengadaan.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div style="margin-top:12px">
    <a href="{{ route('pengadaan.index') }}">Kembali ke daftar</a>
  </div>
@endsection
