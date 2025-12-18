<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BasdatPro</title>
    <style>
        body { font-family: Arial; margin:0; background:#f5f5f5; }
        header { background:#0066cc; color:#fff; padding:10px 20px; }
        .container { display:flex; }
        aside { width:200px; background:#222; color:#fff; min-height:100vh; padding:10px; }
        aside a { color:#fff; text-decoration:none; display:block; margin:8px 0; }
        main { flex:1; padding:20px; background:#fff; }
        table { border-collapse:collapse; width:100%; margin-top:10px; }
        th, td { border:1px solid #ddd; padding:8px; text-align:left; }
        th { background:#eee; }
    </style>
</head>
<body>
    <header>
        <h2>Selamat Datang, {{ $user['username'] }}</h2>
    </header>
    <div class="container">
        <aside>
            <h3>Menu</h3>
            @if($user['role'] == 1)
                <a href="/dashboard">Dashboard</a>
                <a href="#">Kelola User</a>
                <a href="#">Kelola Role</a>
                <a href="#">Kelola Barang</a>
                <a href="#">Kelola Vendor</a>
                <a href="#">Kelola Margin</a>
            @elseif($user['role'] == 2)
                <a href="/dashboard">Dashboard</a>
                <a href="#">Kelola Barang</a>
                <a href="#">Kelola Vendor</a>
                <a href="#">Kelola Margin</a>
            @elseif($user['role'] == 3)
                <a href="/dashboard">Dashboard</a>
                <a href="#">Lihat Barang</a>
            @endif
            <hr>
            <a href="/logout">Logout</a>
        </aside>
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
