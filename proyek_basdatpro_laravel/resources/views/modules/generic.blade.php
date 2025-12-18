@extends('layouts.app')

@section('content')
  <h2>{{ ucwords(str_replace('_',' ', preg_replace('/^view_/', '', $view))) }}</h2>
  <p class="small-muted">Menampilkan 3 baris pertama dari <strong>{{ $view }}</strong></p>

  <div style="overflow:auto; margin-top:12px">
    <table width="100%" style="border-collapse: collapse;">
      <thead>
        <tr style="background:#f4f4f4; text-align:left;">
          @foreach($cols as $c)
            <th style="padding:8px; border-bottom:2px solid #ddd;">{{ $c }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @forelse($rows as $r)
          <tr style="border-bottom:1px solid #eee;">
            @foreach($cols as $c)
              <td style="padding:8px;">{{ data_get($r, $c) }}</td>
            @endforeach
          </tr>
        @empty
          <tr><td colspan="{{ count($cols) }}" style="padding:10px; text-align:center;">Tidak ada data.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:20px;">
    <a href="{{ url('/modules/'.$view.'/full') }}" class="card" style="padding:10px 15px; display:inline-block; text-decoration:none; background:#fff; border:1px solid #ddd; border-radius:4px; color:#333;">
      Lihat Selengkapnya
    </a>

    {{-- Render Tombol Tambahan  --}}
    @if(isset($extraLinks) && count($extraLinks) > 0)
      <div style="margin-top:15px; display:flex; flex-direction:column; gap:10px; max-width:250px;">
        @foreach($extraLinks as $link)
          <a href="{{ $link['url'] }}" class="card" style="padding:10px 15px; display:block; text-decoration:none; background:#fff; border:1px solid #ddd; border-radius:4px; color:#007bff; font-weight:bold;">
            {{ $link['label'] }}
          </a>
        @endforeach
      </div>
    @endif
  </div>
@endsection