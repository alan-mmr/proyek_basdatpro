<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login RSHP</title>

  {{-- INI CSS DARI FILE MU YANG ASLI (CDN) --}}
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>

{{-- PERUBAHAN UTAMA DISINI: Ganti 'layout-top-nav' jadi 'login-page' --}}
<body class="hold-transition login-page">

    {{-- KITA BUAT KOTAK LOGINNYA DISINI --}}
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>RSHP</b> System</a>
        </div>
        
        <div class="card">
            <div class="card-body login-card-body">
                {{-- Form Login akan muncul disini --}}
                @yield('content')
            </div>
        </div>
    </div>

{{-- INI JS DARI FILE MU YANG ASLI --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>