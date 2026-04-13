<?php

namespace App\Livewire;

use Livewire\Component;

class Transaksi extends Component
{
    public $keranjang = [];
    public $total_harga = 0;
    public $bayar = 0;
    public $kembalian = 0;

    public function tambahKeKeranjang($idProduk)
    {
        $produk = \App\Models\Produk::findOrFail($idProduk);

        // Cek stok
        if ($produk->stok < 1) {
            session()->flash('error', 'Stok produk ' . $produk->nama_produk . ' habis!');
            return;
        }

        $keranjangIndex = array_search($idProduk, array_column($this->keranjang, 'id'));

        if ($keranjangIndex !== false) {
            // Cek jika qty melebihi stok
            if ($this->keranjang[$keranjangIndex]['qty'] >= $produk->stok) {
                session()->flash('error', 'Stok tidak mencukupi untuk ditambah!');
                return;
            }
            $this->keranjang[$keranjangIndex]['qty'] += 1;
        } else {
            $this->keranjang[] = [
                'id' => $produk->id,
                'nama_produk' => $produk->nama_produk,
                'harga' => $produk->harga,
                'qty' => 1
            ];
        }

        $this->hitungTotal();
    }

    public function hapusDariKeranjang($index)
    {
        unset($this->keranjang[$index]);
        $this->keranjang = array_values($this->keranjang);
        $this->hitungTotal();
    }

    public function hitungTotal()
    {
        $this->total_harga = array_sum(array_map(function ($item) {
            return $item['harga'] * $item['qty'];
        }, $this->keranjang));

        $this->hitungKembalian();
    }

    public function hitungKembalian()
    {
        $this->kembalian = (int)$this->bayar - $this->total_harga;
    }

    public function checkout()
    {
        if (empty($this->keranjang)) {
            session()->flash('error', 'Keranjang belanja kosong!');
            return;
        }

        if ($this->bayar < $this->total_harga) {
            session()->flash('error', 'Uang bayar kurang!');
            return;
        }

        $transaksi = \App\Models\Transaksi::create([
            'kode_transaksi' => 'TRX-' . time(),
            'total_harga' => $this->total_harga,
            'status' => 'selesai'
        ]);

        foreach ($this->keranjang as $item) {
            \App\Models\DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item['id'],
                'qty' => $item['qty'],
                'harga' => $item['harga']
            ]);

            // Kurangi stok
            $produk = \App\Models\Produk::find($item['id']);
            $produk->stok -= $item['qty'];
            $produk->save();
        }

        // Reset
        $this->keranjang = [];
        $this->total_harga = 0;
        $this->bayar = 0;
        $this->kembalian = 0;

        session()->flash('success', 'Transaksi berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.transaksi', [
            'semuaProduk' => \App\Models\Produk::where('stok', '>', 0)->get()
        ]);
    }
}