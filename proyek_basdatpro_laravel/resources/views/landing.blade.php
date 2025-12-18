{{-- resources/views/landing.blade.php --}}
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>QYU Inventaris — Selamat datang</title>

  {{-- Jika proyek sudah pakai Tailwind, style berikut akan dipakai.
      Jika belum, ada fallback CSS agar tetap rapi. --}}
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <style>
    /* fallback/basic styles jika Tailwind tidak tersedia */
    body { font-family: Inter, system-ui, Arial; margin:0; background: linear-gradient(180deg,#fff 0%, #fff 60%, #f8f8f8 100%); }
    .btn-primary { background:#c92b2b; color:#fff; padding:12px 20px; border-radius:10px; text-decoration:none; display:inline-block; }
    .card { max-width:920px; margin:48px auto; padding:28px; border-radius:16px; box-shadow:0 6px 30px rgba(0,0,0,0.08); background: #fff; }
    @media (max-width:640px){ .card{ margin:20px; padding:18px } }
  </style>
</head>
<body class="bg-white text-gray-800">

  <main class="min-h-screen flex items-center justify-center px-4">
    <section class="card flex flex-col md:flex-row items-center gap-8">
      {{-- left: text --}}
      <div class="flex-1">
        <div class="flex items-center gap-3">
          <div class="w-14 h-14 rounded-md flex items-center justify-center" style="background:#c92b2b">
            <span style="color:#fff;font-weight:700;font-size:20px">QYU</span>
          </div>
          <div>
            <h1 class="text-2xl md:text-3xl font-extrabold">QYU Inventaris</h1>
            <p class="text-sm text-gray-600 mt-1">Sistem inventaris sederhana </p>
          </div>
        </div>

        <p class="mt-6 text-gray-700 leading-relaxed">
          Selamat datang di QYU Inventaris.
        </p>
        <p class="mt-6 text-gray-700 leading-relaxed">
             Untuk melanjutkan, silakan masuk menggunakan akun Anda.
          Halaman ini dibuat sebagai landing page publik — fitur hanya tersedia setelah login.
        </p>

        <div class="mt-8">
          <a href="{{ route('login') }}" class="inline-block px-6 py-3 rounded-lg font-medium"
             style="background:#c92b2b;color:#fff;text-decoration:none;box-shadow:0 6px 18px rgba(201,43,43,0.25)">
            Masuk / Login
          </a>
        </div>

        <ul class="mt-6 text-xs text-gray-500 space-y-1">
     <strong>Catatan dev:</strong> landing page ini publik — tidak menampilkan data sensitif.
        </ul>
      </div>

      {{-- right: ilustrasi / card kecil --}}
      <div class="w-full md:w-96">
        <div style="background:linear-gradient(180deg,#fff 0,#fff 60%);" class="p-5 rounded-lg border border-gray-100">
          <h3 class="font-semibold text-lg mb-3">Fitur </h3>
          <ol class="text-sm text-gray-600 space-y-2 list-decimal list-inside">
            <li>Manajemen Barang</li>
            <li>Pengadaan & Penerimaan</li>
            <li>Kartu Stok otomatis</li>
            <li>Penjualan (read-only pada detail transaksi)</li>
          </ol>

          
        </div>
      </div>
    </section>
  </main>

  {{-- small footer --}}
  <footer class="text-center text-xs text-gray-400 pb-6">
    &copy; {{ date('Y') }} QYU Inventaris — Sistem Proyek Basdat
  </footer>
</body>
</html>
