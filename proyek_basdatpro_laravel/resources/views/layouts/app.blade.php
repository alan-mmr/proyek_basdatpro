<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Inventaris QYU</title>
  <style>
    :root{
      --header-height:64px;
      --sidebar-width:260px;
      --red:#c92b2b;
      --muted:#f6f7f8;
      --text:#222;
      --sidebar-bg:#fff;
      --border:#e6e6e6;
      --radius:8px;
    }
    *{box-sizing:border-box;font-family:Inter, system-ui, -apple-system, "Segoe UI", Roboto, Arial;}
    html,body,#app{height:100%;margin:0;color:var(--text);background:#fff}
    header{
      position:fixed;left:0;right:0;top:0;height:var(--header-height);
      background:var(--red);color:#fff;display:flex;align-items:center;
      padding:0 18px;font-weight:600;z-index:40;border-bottom:1px solid rgba(0,0,0,0.04);
    }
    .container{display:flex;padding-top:var(--header-height);min-height:calc(100vh - var(--header-height));}
    nav.sidebar{
      width:var(--sidebar-width);min-width:var(--sidebar-width);
      background:var(--sidebar-bg);border-right:1px solid var(--border);
      height:calc(100vh - var(--header-height));position:sticky;top:var(--header-height);
      padding:18px 12px;overflow:auto;
    }
    .brand{display:flex;align-items:center;gap:8px;padding:8px 6px;margin-bottom:12px}
    .brand .logo{width:34px;height:34px;border-radius:6px;background:#fff;color:var(--red);display:flex;align-items:center;justify-content:center;font-weight:700;border:2px solid rgba(0,0,0,0.03)}
    .menu{margin-top:12px}
    .menu a{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:8px;color:var(--text);text-decoration:none;margin-bottom:6px;font-size:14px}
    .menu a.active{background:linear-gradient(90deg, rgba(201,43,43,0.06), rgba(201,43,43,0.03));font-weight:600}
    .menu a:hover{background:rgba(0,0,0,0.03)}
    main.content{flex:1;padding:28px 32px;min-height:100vh;background:#fbfbfb}
    footer.site-footer{padding:16px 28px;border-top:1px solid var(--border);color:#666;font-size:13px;background:#fff;position:sticky;bottom:0;margin-top:18px}
    .card{background:#fff;border:1px solid var(--border);padding:18px;border-radius:10px}
    table{width:100%;border-collapse:collapse}
    table th, table td{padding:10px 8px;border-bottom:1px solid #f0f0f0;text-align:left;font-size:14px}
    .topbar-right{margin-left:auto;color:#fff;font-weight:500}
    .small-muted{color:#777;font-size:13px}
    @media(max-width:900px){nav.sidebar{display:none}.container{padding-left:12px;padding-right:12px}}
  </style>
</head>
<body>
  <div id="app">
    <header>
      <div style="display:flex;align-items:center;gap:12px">
        <div style="width:36px;height:36px;border-radius:6px;background:#fff;color:var(--red);display:flex;align-items:center;justify-content:center;font-weight:700">Q</div>
        <div>Inventaris QYU</div>
      </div>

      <div class="topbar-right">
        @if(session('user'))
          {{ session('user.username') }} • {{ session('user.nama_role') }}
          <form method="post" action="{{ route('logout') }}" style="display:inline;margin-left:12px">
            @csrf
            <button type="submit" style="background:transparent;border:1px solid rgba(255,255,255,0.15);color:#fff;padding:6px 8px;border-radius:6px;cursor:pointer">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" style="color:#fff;text-decoration:underline">Login</a>
        @endif
      </div>
    </header>

    <div class="container">
      <nav class="sidebar">
        <div class="brand">
          <div class="logo">Q</div>
          <div>
            <div style="font-weight:700">QYU</div>
            <div class="small-muted" style="font-size:12px">Sistem Inventaris</div>
          </div>
        </div>

        @php
          use Illuminate\Support\Facades\DB;

          // 1. Ambil daftar view dari database
          $dbName = config('database.connections.mysql.database');
          $rows = DB::select("SELECT TABLE_NAME as name FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = ? AND TABLE_NAME LIKE 'view_%' ORDER BY TABLE_NAME", [$dbName]);
          $viewList = array_map(fn($x) => $x->name, $rows);

          // 2. LABEL MAPPING (Nama Manusiawi)
          $label_map = [
            // Master Data
            'view_barang_satuan'    => 'Master Barang & Stok',
            'view_vendor_status'    => 'Master Vendor',
            'view_user_role'        => 'Manajemen User & Role',

            // Transaksi Masuk (Inbound)
            'view_pengadaan_vendor_user'     => 'Riwayat Pengadaan (PO)',
            'view_detail_pengadaan_lengkap'  => 'Laporan Detail Pengadaan',
            'view_penerimaan_pengadaan_user' => 'Riwayat Penerimaan Gudang',
            'view_detail_penerimaan_lengkap' => 'Laporan Barang Masuk',

            // Transaksi Keluar (Outbound)
            'view_penjualan_margin_user'     => 'Riwayat Penjualan',
            'view_detail_penjualan_lengkap'  => 'Laporan Barang Keluar',

            // Laporan & Stok
            'view_kartu_stok_barang'         => 'Kartu Stok (Log Mutasi)',
          ];

          // 3. URUTAN MENU (ORDERED)
          $ordered = [
            // Group Master
            'view_barang_satuan',
            'view_vendor_status',
            'view_user_role',
            
            // Group Transaksi
            'view_pengadaan_vendor_user',
            'view_penerimaan_pengadaan_user',
            'view_penjualan_margin_user',
            
            // Group Laporan Detail
            'view_kartu_stok_barang',
            'view_detail_pengadaan_lengkap',
            'view_detail_penerimaan_lengkap',
            'view_detail_penjualan_lengkap',
          ];

          // 4. Role-Based Access Control (RBAC)
          $role = session('user.nama_role') ?? null;
          $denyForAdmin = ['view_user_role']; // Admin tidak boleh lihat user role

          if($role === 'Super Admin' || $role === 'Superadmin'){
            $allowedViews = $viewList;
          } else if($role === 'Admin'){
            $allowedViews = array_values(array_filter($viewList, fn($v) => !in_array($v, $denyForAdmin)));
          } else if($role === 'Manager'){
            $keywords = ['laporan','barang','penjualan','margin','kartu'];
            $allowedViews = array_values(array_filter($viewList, fn($v) => collect($keywords)->contains(fn($k)=> str_contains($v,$k))));
          } else if($role === 'Staff'){
            $keywords = ['barang','satuan','vendor','penjualan'];
            $allowedViews = array_values(array_filter($viewList, fn($v) => collect($keywords)->contains(fn($k)=> str_contains($v,$k))));
          } else if($role === 'Gudang'){
            $keywords = ['barang','satuan','kartu','stok','penerimaan'];
            $allowedViews = array_values(array_filter($viewList, fn($v) => collect($keywords)->contains(fn($k)=> str_contains($v,$k))));
          } else {
            // Guest / Belum Login
            $allowedViews = [];
          }

          // Helper function untuk label
          $human_label = function($v) use ($label_map) {
            if(isset($label_map[$v])) return $label_map[$v];
            // Fallback: rapikan nama view aslinya
            $s = preg_replace('/^view_/', '', $v);
            $s = preg_replace('/_lengkap$/','',$s);
            $s = str_replace('_',' ',$s);
            return ucwords($s);
          };

          $allowedSet = array_flip($allowedViews);
          $viewSet = array_flip($viewList);
        @endphp

        <div class="menu">
          {{-- Dashboard Link --}}
          <a href="{{ route('dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">
             🏠 Dashboard
          </a>

          {{-- Render Menu Sesuai Urutan --}}
          @foreach($ordered as $v)
            @if(isset($viewSet[$v]) && isset($allowedSet[$v]))
              @php
                $label = $human_label($v);
                $url = url('/modules/'.$v);
                $isActive = Request::is('modules/'.$v) ? 'active' : '';
              @endphp
              <a href="{{ $url }}" class="{{ $isActive }}">{{ $label }}</a>
            @endif
          @endforeach

          {{-- Render Sisa Menu (Yang tidak ada di ordered list) --}}
          @php
            $remaining = array_values(array_filter($allowedViews, fn($vv) => !in_array($vv, $ordered)));
          @endphp

          @if(count($remaining) > 0)
             <hr style="margin:10px 0; border:0; border-top:1px solid #eee;">
             <div style="padding:0 12px; font-size:11px; color:#999; font-weight:bold; margin-bottom:5px;">LAINNYA</div>
          @endif

          @foreach($remaining as $v)
            @php
              $label = $human_label($v);
              $url = url('/modules/'.$v);
              $isActive = Request::is('modules/'.$v) ? 'active' : '';
            @endphp
            <a href="{{ $url }}" class="{{ $isActive }}">{{ $label }}</a>
          @endforeach
        </div>

        <div style="position:absolute;bottom:18px;left:12px;right:12px;font-size:13px;color:#888">
          © 2025 Sistem Inventaris QYU
        </div>
      </nav>

      <main class="content">
        <div class="card">
          @yield('content')
        </div>

        <footer class="site-footer">
          © 2025 Sistem Inventaris QYU — Project BasdatPro
        </footer>
      </main>
    </div>
  </div>
</body>
</html>