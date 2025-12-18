@extends('layouts.app')

@section('content')

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 15px;">
      <h2 style="margin:0;">{{ ucwords(str_replace('_',' ', preg_replace('/^view_/', '', $view))) }}</h2>
  </div>

  {{-- LOGIKA TOMBOL FILTER (Hanya Muncul Jika Ada Kolom Status) --}}
  @if($hasStatus)
    <div style="margin-bottom: 20px; padding: 10px; background: #f9f9f9; border: 1px solid #eee; border-radius: 8px; display:flex; align-items: center; gap: 15px;">
        <strong style="font-size: 14px; color: #555;">Filter Data:</strong>
        
        {{-- Tombol Aktif (Default) --}}
        <a href="{{ url()->current() }}?status=1" 
           style="text-decoration: none; padding: 6px 12px; border-radius: 4px; font-size: 13px; font-weight: 600; border: 1px solid #28a745;
           {{ $currentStatus == '1' ? 'background: #28a745; color: white;' : 'background: white; color: #28a745;' }}">
           ✓ Hanya Aktif
        </a>

        {{-- Tombol Non-Aktif --}}
        <a href="{{ url()->current() }}?status=0" 
           style="text-decoration: none; padding: 6px 12px; border-radius: 4px; font-size: 13px; font-weight: 600; border: 1px solid #dc3545;
           {{ $currentStatus == '0' ? 'background: #dc3545; color: white;' : 'background: white; color: #dc3545;' }}">
           ✕ Non-Aktif
        </a>

        {{-- Tombol Semua --}}
        <a href="{{ url()->current() }}?status=all" 
           style="text-decoration: none; padding: 6px 12px; border-radius: 4px; font-size: 13px; font-weight: 600; border: 1px solid #6c757d;
           {{ $currentStatus === 'all' ? 'background: #6c757d; color: white;' : 'background: white; color: #6c757d;' }}">
           ≣ Tampilkan Semua
        </a>
    </div>
  @endif

  <div style="overflow:auto;">
    <table width="100%" style="border-collapse: collapse;">
      <thead>
        <tr style="background:#eee;">
          @foreach($cols as $c)
            <th style="padding:12px; border-bottom:2px solid #ddd; text-align:left; font-size: 13px; text-transform: uppercase; color: #444;">{{ $c }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @forelse($rows as $r)
          <tr style="border-bottom:1px solid #eee;">
            @foreach($cols as $c)
              <td style="padding:10px; font-size: 14px;">
                {{-- Percantik tampilan kolom Status jika ada --}}
                @if($c === 'status' && $hasStatus)
                    @if(data_get($r, $c) == 1)
                        <span style="background:#e8f5e9; color:#2e7d32; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:bold;">AKTIF</span>
                    @else
                        <span style="background:#ffebee; color:#c62828; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:bold;">NON-AKTIF</span>
                    @endif
                @else
                    {{ data_get($r,$c) }}
                @endif
              </td>
            @endforeach
          </tr>
        @empty
          <tr><td colspan="{{ count($cols) }}" style="padding:30px; text-align:center; color: #888;">Tidak ada data yang ditemukan.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:20px;">
    {!! $rows->links() !!}
  </div>

@endsection