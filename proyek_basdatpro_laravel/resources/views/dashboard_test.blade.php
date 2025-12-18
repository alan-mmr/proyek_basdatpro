@extends('layouts.app')

@section('content')
  <h2>Dashboard (TEST)</h2>
  <p class="small-muted">Testing view_barang_satuan on DB: <strong>{{ $db }}</strong></p>

  @if(empty($barang))
    <p>Tidak ada view 'view_barang_satuan' atau kosong.</p>
  @else
    <table>
      <thead>
        <tr>
          @foreach(array_keys((array)$barang[0]) as $col)
            <th>{{ $col }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @foreach($barang as $row)
          <tr>
            @foreach((array)$row as $cell)
              <td>{{ $cell }}</td>
            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@endsection
