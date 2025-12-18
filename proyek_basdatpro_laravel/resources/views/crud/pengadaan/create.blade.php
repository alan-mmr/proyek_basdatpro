@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    
    <div style="margin-bottom: 20px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h3 style="margin:0;">Buat Purchase Order (PO)</h3>
            <p class="small-muted" style="margin:5px 0 0;">Pesan barang ke vendor untuk stok gudang.</p>
        </div>
        <a href="{{ route('pengadaan.index') }}" style="text-decoration:none; color:#666; font-size:14px;">
            ← Kembali
        </a>
    </div>

    @if(session('error'))
        <div style="background:#ffebee; color:#c62828; padding:15px; border-radius:6px; margin-bottom:20px; border:1px solid #ef9a9a;">
            <strong>Error:</strong> {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('pengadaan.store') }}">
        @csrf

        {{-- Bagian Vendor --}}
        <div class="card" style="background:white; padding:20px; border-radius:8px; border:1px solid #eee; margin-bottom:20px;">
            <label style="font-weight:600; font-size:13px; display:block; margin-bottom:5px;">Pilih Vendor <span style="color:red">*</span></label>
            <select name="vendor_id" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px; background:white;">
                <option value="">-- Pilih Vendor --</option>
                @foreach($vendors as $v)
                    <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
                @endforeach
            </select>
        </div>

        {{-- Bagian Item Barang --}}
        <div class="card" style="background:white; padding:0; border-radius:8px; border:1px solid #eee; overflow:hidden;">
            <div style="padding:15px 20px; background:#f9f9f9; border-bottom:1px solid #eee;">
                <h4 style="margin:0; font-size:15px;">Daftar Barang</h4>
            </div>
            
            <table width="100%" style="border-collapse: collapse;">
                <thead>
                    <tr style="background:#fff; border-bottom:1px solid #eee; text-align:left;">
                        <th style="padding:12px 20px; width:40%;">Nama Barang</th>
                        <th style="padding:12px 10px; width:20%;">Harga Beli (Rp)</th>
                        <th style="padding:12px 10px; width:15%;">Qty</th>
                        <th style="padding:12px 10px; width:20%;">Subtotal</th>
                        <th style="padding:12px 10px; width:5%;"></th>
                    </tr>
                </thead>
                <tbody id="cart-body">
                    {{-- Baris Item akan muncul di sini via JS --}}
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="padding:15px 20px;">
                            <button type="button" onclick="addItem()" style="background:#28a745; color:white; border:none; padding:8px 15px; cursor:pointer; border-radius:4px; font-size:13px;">
                                + Tambah Baris
                            </button>
                        </td>
                    </tr>
                    <tr style="background:#fcfcfc; border-top:2px solid #eee;">
                        <td colspan="3" style="padding:15px 20px; text-align:right; font-weight:bold;">
                            Estimasi Total (+ PPN 10%):
                        </td>
                        <td colspan="2" style="padding:15px 10px; color:#c92b2b; font-weight:bold; font-size:16px;">
                            <span id="grand-total">Rp 0</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Tombol Aksi --}}
        <div style="margin-top:25px; text-align:right;">
            <a href="{{ route('pengadaan.index') }}" style="text-decoration:none; color:#555; margin-right:20px; font-size:14px;">Batal</a>
            <button type="submit" style="background:#007bff; color:white; border:none; padding:12px 30px; border-radius:6px; font-weight:600; cursor:pointer; font-size:14px;">
                Simpan Pengadaan
            </button>
        </div>

    </form>
</div>

<script>
    const barangData = @json($barangs);

    function addItem() {
        const index = document.querySelectorAll('.item-row').length;
        const tr = document.createElement('tr');
        tr.classList.add('item-row');
        tr.style.borderBottom = '1px solid #f5f5f5';
        
        let options = '<option value="">-- Pilih Barang --</option>';
        barangData.forEach(b => {
            // Kita simpan harga default di attribute data-harga
            options += `<option value="${b.idbarang}" data-harga="${b.harga}">${b.nama}</option>`;
        });

        tr.innerHTML = `
            <td style="padding:10px 20px;">
                <select name="items[${index}][idbarang]" onchange="setPrice(this)" required style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                    ${options}
                </select>
            </td>
            <td style="padding:10px;">
                <input type="number" name="items[${index}][harga_satuan]" class="price-input" oninput="calcTotal()" placeholder="0" required style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
            </td>
            <td style="padding:10px;">
                <input type="number" name="items[${index}][jumlah]" class="qty-input" min="1" value="1" oninput="calcTotal()" required style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
            </td>
            <td style="padding:10px;">
                <span class="subtotal-display" style="font-weight:600; color:#333;">Rp 0</span>
            </td>
            <td style="padding:10px; text-align:center;">
                <button type="button" onclick="removeItem(this)" style="color:#dc3545; border:none; background:none; cursor:pointer; font-weight:bold;">✕</button>
            </td>
        `;
        
        document.getElementById('cart-body').appendChild(tr);
    }

    function setPrice(select) {
        const row = select.closest('tr');
        const opt = select.options[select.selectedIndex];
        const harga = opt.getAttribute('data-harga') || 0;
        const inputHarga = row.querySelector('.price-input');
        
        // Auto isi harga jika kosong
        if(inputHarga.value == "" || inputHarga.value == 0) {
            inputHarga.value = harga;
        }
        calcTotal();
    }

    function calcTotal() {
        let total = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const sub = price * qty;
            row.querySelector('.subtotal-display').innerText = 'Rp ' + sub.toLocaleString('id-ID');
            total += sub;
        });

        // Hitung PPN 10% (Hanya Estimasi Tampilan)
        const ppn = total * 0.10;
        const grand = total + ppn;

        document.getElementById('grand-total').innerText = 'Rp ' + grand.toLocaleString('id-ID');
    }

    function removeItem(btn) {
        btn.closest('tr').remove();
        calcTotal();
    }

    // Tambah 1 baris otomatis saat load
    window.onload = addItem;
</script>
@endsection