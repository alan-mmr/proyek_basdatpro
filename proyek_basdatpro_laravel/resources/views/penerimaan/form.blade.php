@extends('layouts.app')
@section('content')

<h3>Penerimaan Barang</h3>

<form action="{{ route('penerimaan.receive') }}" method="POST">
  @csrf

  <input type="hidden" name="idpengadaan" value="{{ $pengadaan->idpengadaan }}">

  <table>
    <thead>
      <tr>
        <th>Barang</th>
        <th>Jumlah Dipesan</th>
        <th>Harga Satuan</th>
        <th>Jumlah Diterima</th>
      </tr>
    </thead>
    <tbody>
      @foreach($detail as $d)
      <tr>
        <td>{{ $d->nama_barang }}</td>
        <td>{{ $d->jumlah }}</td>
        <td>{{ $d->harga_satuan }}</td>
        <td>
          <input type="number" name="items[{{ $loop->index }}][jumlah_terima]" min="0" required>
          <input type="hidden" name="items[{{ $loop->index }}][idbarang]" value="{{ $d->idbarang }}">
          <input type="hidden" name="items[{{ $loop->index }}][harga_satuan]" value="{{ $d->harga_satuan }}">
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <button type="submit">Simpan Penerimaan</button>
</form>

@endsection
