@extends('layouts.app')

@section('content')
<h3>Transaksi Penjualan Baru (Kasir)</h3>

@if(session('error'))
    <div style="background:#ffebee; color:#c62828; padding:10px; border-radius:4px; margin-bottom:15px; border:1px solid #ef9a9a;">
        <strong>Error:</strong> {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('penjualan.store') }}">
    @csrf
    
    {{-- REVISI: Dropdown Customer DIHAPUS --}}
    
    <div class="card" style="background:#f9f9f9; padding:15px;">
        <h4>Keranjang Belanja</h4>
        <table width="100%" style="border-collapse: collapse;">
            <thead>
                <tr style="text-align:left; border-bottom:2px solid #ddd;">
                    <th width="40%">Barang</th>
                    <th width="15%">Stok</th>
                    <th width="20%">Harga</th>
                    <th width="15%">Qty</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody id="cart-body">
                {{-- Item rows will appear here --}}
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="padding-top:10px;">
                        <button type="button" onclick="addItem()" style="background:#28a745; color:white; border:none; padding:5px 10px; cursor:pointer; border-radius:4px;">+ Tambah Barang</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div style="margin-top:20px;">
        <button type="submit" style="background:#007bff; color:white; border:none; padding:10px 20px; border-radius:4px; cursor:pointer;">Simpan Transaksi</button>
        <a href="{{ route('dashboard') }}" style="margin-left:10px; color:#666;">Batal</a>
    </div>
</form>

<script>
    const barangData = @json($barangs);

    function addItem() {
        const index = document.querySelectorAll('.item-row').length;
        const tr = document.createElement('tr');
        tr.classList.add('item-row');
        tr.style.borderBottom = '1px solid #eee';
        
        let options = '<option value="">-- Pilih --</option>';
        barangData.forEach(b => {
            const stok = b.stok_saat_ini || 0;
            const disabled = stok <= 0 ? 'disabled' : '';
            const label = b.nama + (stok <= 0 ? ' (Habis)' : '');
            options += `<option value="${b.idbarang}" data-harga="${b.harga}" data-stok="${stok}" ${disabled}>${label}</option>`;
        });

        tr.innerHTML = `
            <td style="padding:10px 5px;">
                <select name="items[${index}][idbarang]" onchange="updateInfo(this)" required style="width:100%; padding:5px;">
                    ${options}
                </select>
            </td>
            <td style="padding:10px 5px;">
                <span class="stok-info">-</span>
            </td>
            <td style="padding:10px 5px;">
                <span class="harga-info">Rp 0</span>
            </td>
            <td style="padding:10px 5px;">
                <input type="number" name="items[${index}][jumlah]" min="1" value="1" required style="width:60px; padding:5px;">
            </td>
            <td style="padding:10px 5px;">
                <button type="button" onclick="this.closest('tr').remove()" style="color:red; border:none; background:none; cursor:pointer;">Hapus</button>
            </td>
        `;
        
        document.getElementById('cart-body').appendChild(tr);
    }

    function updateInfo(select) {
        const row = select.closest('tr');
        const opt = select.options[select.selectedIndex];
        const stok = opt.getAttribute('data-stok') || 0;
        const harga = opt.getAttribute('data-harga') || 0;
        
        row.querySelector('.stok-info').innerText = stok;
        row.querySelector('.stok-info').style.color = stok < 5 ? 'red' : 'black';
        row.querySelector('.harga-info').innerText = 'Rp ' + Number(harga).toLocaleString('id-ID');
        
        const qtyInput = row.querySelector('input[type="number"]');
        qtyInput.max = stok; // Mencegah input melebihi stok
    }

    window.onload = addItem;
</script>
@endsection