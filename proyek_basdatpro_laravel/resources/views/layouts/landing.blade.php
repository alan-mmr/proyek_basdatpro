<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title','Inventaris — Selamat Datang')</title>

  <!-- Tailwind CDN (dev) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* sedikit penyesuaian agar seragam dengan layout lain */
    body { background-color: #f8fafc; }
    .card { @apply bg-white p-4 rounded-lg shadow-sm; }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center">
  <div class="w-full max-w-4xl p-6">
    <header class="mb-8 text-center">
      <h1 class="text-3xl font-semibold">Inventaris — Selamat Datang</h1>
      <p class="text-sm text-gray-500 mt-2">Sistem manajemen inventaris sederhana</p>
    </header>

    <main>
      @yield('content')
    </main>

    <footer class="mt-8 text-center text-xs text-gray-400">
      &copy; {{ date('Y') }} — Proyek BasdatPro
    </footer>
  </div>
</body>
</html>
