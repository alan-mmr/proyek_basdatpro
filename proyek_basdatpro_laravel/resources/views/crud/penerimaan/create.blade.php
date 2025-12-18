@extends('layouts.app')

@section('content')
<h3>Penerimaan Barang (Inbound)</h3>

@if(session('error'))
    <div style="background:#ffebee; color:#c62828; padding:10px; border-radius:4px; margin-bottom:15px; border:1px solid #ef9a9a;">
        <strong>Error:</strong> {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('penerimaan.receive') }}">
    @csrf
    
    <div style="margin-bottom:20px;">
        <label>Pilih Nomor Pengadaan:</label><br>
        <select name="idpengadaan" id="select-pengadaan" required style="padding:8px; width:100%; max-width:400px;">
            <option value="">-- Pilih Pengadaan --</option>
            @foreach($pengadaans as $p)
                <option value="{{ $p->idpengadaan }}" data-details='@json($p->details)'>
                    ID: {{ $p->idpengadaan }} — {{ $p->nama_vendor }} ({{ $p->timestamp }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="card" style="background:#f9f9f9; padding:15px;">
        <h4>Daftar Barang yang Dipesan</h4>
        <table width="100%" style="border-collapse: collapse;">
            <thead>
                <tr style="text-align:left; border-bottom:2px solid #ddd; background:#eee;">
                    <th style="padding:10px;">Barang</th>
                    <th style="padding:10px; text-align:center;">Jml Pesan</th>
                    <th style="padding:10px; text-align:center;">Sdh Terima</th>
                    <th style="padding:10px; text-align:center;">Sisa</th>
                    <th style="padding:10px; width:150px;">Terima Sekarang</th>
                </tr>
            </thead>
            <tbody id="items-body">
                <tr><td colspan="5" style="padding:15px; text-align:center; color:#777;">Silakan pilih pengadaan di atas.</td></tr>
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        <button type="submit" style="background:#28a745; color:white; border:none; padding:10px 20px; border-radius:4px; cursor:pointer;">Simpan Penerimaan</button>
    </div>
</form>

<script>
    const selectPengadaan = document.getElementById('select-pengadaan');
    const itemsBody = document.getElementById('items-body');

    selectPengadaan.addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        itemsBody.innerHTML = ''; // Clear

        if (!opt.value) {
            itemsBody.innerHTML = '<tr><td colspan="5" style="padding:15px; text-align:center; color:#777;">Silakan pilih pengadaan di atas.</td></tr>';
            return;
        }

        const details = JSON.parse(opt.getAttribute('data-details'));

        if (details.length === 0) {
            itemsBody.innerHTML = '<tr><td colspan="5" style="padding:15px; text-align:center;">Tidak ada data barang.</td></tr>';
            return;
        }

        details.forEach((item, index) => {
            const sisa = item.qty_pesan - item.qty_sudah_terima;
            const isCompleted = sisa <= 0;
            
            // Warna baris: Hijau muda jika selesai, Putih jika belum
            const bgColor = isCompleted ? '#e8f5e9' : '#fff';
            const disabledAttr = isCompleted ? 'disabled' : '';
            const valAttr = isCompleted ? 0 : sisa; // Default isi max sisa

            const row = `
                <tr style="border-bottom:1px solid #ddd; background-color:${bgColor}">
                    <td style="padding:10px;">
                        <strong>${item.nama_barang}</strong>
                        <input type="hidden" name="items[${index}][idbarang]" value="${item.idbarang}">
                    </td>
                    <td style="padding:10px; text-align:center;">${item.qty_pesan}</td>
                    <td style="padding:10px; text-align:center;">${item.qty_sudah_terima}</td>
                    <td style="padding:10px; text-align:center; font-weight:bold; color:${isCompleted ? 'green' : 'red'}">
                        ${sisa}
                    </td>
                    <td style="padding:10px;">
                        <input type="number" 
                               name="items[${index}][jumlah_terima]" 
                               value="${isCompleted ? 0 : ''}" 
                               min="0" 
                               max="${sisa}" 
                               class="form-control" 
                               style="width:100%; padding:5px;"
                               ${disabledAttr}
                               placeholder="Max: ${sisa}">
                    </td>
                </tr>
            `;
            itemsBody.insertAdjacentHTML('beforeend', row);
        });
    });
</script>
@endsection