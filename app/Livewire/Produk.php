<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Produk as ProdukModel; // Kita gunakan alias yang sangat berbeda
use Illuminate\Support\Facades\Auth;

class Produk extends Component
{
    public $pilihanMenu = 'lihat';
    public $kode_produk, $nama_produk, $harga, $stok;
    public $produkTerpilih;

    // Pastikan mount untuk keamanan jika perlu
    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    }

    public function simpan()
    {
        $this->validate([
            'kode_produk' => 'required|unique:produks,kode_produk',
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);

        ProdukModel::create([
            'kode_produk' => $this->kode_produk,
            'nama_produk' => $this->nama_produk,
            'harga' => $this->harga,
            'stok' => $this->stok,
        ]);

        session()->flash('message', 'Produk berhasil ditambahkan');
        $this->batal();
    }

    public function pilihEdit($id)
    {
        $this->produkTerpilih = ProdukModel::findOrFail($id);
        $this->kode_produk = $this->produkTerpilih->kode_produk;
        $this->nama_produk = $this->produkTerpilih->nama_produk;
        $this->harga = $this->produkTerpilih->harga;
        $this->stok = $this->produkTerpilih->stok;
        $this->pilihanMenu = 'edit';
    }

    public function simpanEdit()
    {
        if (!$this->produkTerpilih) return;

        $this->validate([
            'kode_produk' => 'required|unique:produks,kode_produk,' . $this->produkTerpilih->id,
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);

        $this->produkTerpilih->update([
            'kode_produk' => $this->kode_produk,
            'nama_produk' => $this->nama_produk,
            'harga' => $this->harga,
            'stok' => $this->stok,
        ]);

        session()->flash('message', 'Produk berhasil diupdate');
        $this->batal();
    }

    public function pilihHapus($id)
    {
        $this->produkTerpilih = ProdukModel::findOrFail($id);
        $this->pilihanMenu = 'hapus';
    }

    public function hapus()
    {
        if ($this->produkTerpilih) {
            $this->produkTerpilih->delete();
            session()->flash('message', 'Produk berhasil dihapus');
        }
        $this->batal();
    }

    public function pilihMenu($menu)
    {
        $this->pilihanMenu = $menu;
    }

    public function batal()
    {
        $this->reset(['kode_produk', 'nama_produk', 'harga', 'stok', 'produkTerpilih']);
        $this->pilihanMenu = 'lihat';
    }

    public function render()
    {
        return view('livewire.produk', [
            // Gunakan alias ProdukModel di sini
            'semuaProduk' => ProdukModel::latest()->get()
        ]);
    }
}