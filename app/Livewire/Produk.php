<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Produk as ProdukModel;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage; // Tambahkan ini untuk mempermudah hapus file

class Produk extends Component
{
    use WithFileUploads; 

    public $cari = '';
    public $sortKolom = 'nama_produk';
    public $sortOrder = 'asc';
    public $pilihanMenu = 'lihat';

    public $id_produk, $kode_produk, $nama_produk, $harga, $stok, $foto;

    public function urutkan($kolom)
    {
        if ($this->sortKolom === $kolom) {
            $this->sortOrder = $this->sortOrder === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortKolom = $kolom;
            $this->sortOrder = 'asc';
        }
    }

    public function pilihMenu($menu)
    {
        $this->pilihanMenu = $menu;
        if ($menu == 'tambah') {
            $this->reset(['kode_produk', 'nama_produk', 'harga', 'stok', 'id_produk', 'foto']);
        }
    }

    public function simpan()
    {
        $this->validate([
            'kode_produk' => 'required|unique:produks,kode_produk',
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto' => 'nullable|image|max:1024', 
        ]);

        $pathFoto = null;
        if ($this->foto) {
            // Memastikan folder 'produk' ada dan menyimpan file
            $pathFoto = $this->foto->store('produk', 'public');
        }

        ProdukModel::create([
            'kode_produk' => $this->kode_produk,
            'nama_produk' => $this->nama_produk,
            'harga' => $this->harga,
            'stok' => $this->stok,
            'foto' => $pathFoto,
        ]);

        // SANGAT PENTING: reset() membersihkan property agar input file tidak error di upload berikutnya
        $this->reset(['kode_produk', 'nama_produk', 'harga', 'stok', 'foto', 'id_produk']); 
        $this->pilihMenu('lihat');
    }

    public function pilihEdit($id)
    {
        $produk = ProdukModel::findOrFail($id);
        $this->id_produk = $produk->id;
        $this->kode_produk = $produk->kode_produk;
        $this->nama_produk = $produk->nama_produk;
        $this->harga = $produk->harga;
        $this->stok = $produk->stok;
        $this->foto = null; // Reset input foto saat mulai edit
        $this->pilihanMenu = 'edit';
    }

    public function simpanEdit()
    {
        $this->validate([
            'kode_produk' => 'required|unique:produks,kode_produk,'.$this->id_produk,
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto' => 'nullable|image|max:1024',
        ]);

        $produk = ProdukModel::findOrFail($this->id_produk);
        
        $dataUpdate = [
            'kode_produk' => $this->kode_produk,
            'nama_produk' => $this->nama_produk,
            'harga' => $this->harga,
            'stok' => $this->stok,
        ];

        if ($this->foto) {
            // Hapus foto LAMA jika user upload foto BARU saat edit
            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }
            $dataUpdate['foto'] = $this->foto->store('produk', 'public');
        }

        $produk->update($dataUpdate);
        $this->reset(['foto']); // Bersihkan property foto setelah update
        $this->pilihMenu('lihat');
    }

    public function pilihHapus($id)
    {
        $produk = ProdukModel::findOrFail($id);
        $this->id_produk = $produk->id;
        $this->nama_produk = $produk->nama_produk;
        $this->pilihanMenu = 'hapus';
    }

    public function hapus()
    {
        $produk = ProdukModel::findOrFail($this->id_produk);
        
        if ($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }
        
        $produk->delete();
        $this->pilihMenu('lihat');
    }

    public function render()
    {
        return view('livewire.produk', [
            'semuaProduk' => ProdukModel::where('nama_produk', 'like', '%' . $this->cari . '%')
                ->orWhere('kode_produk', 'like', '%' . $this->cari . '%')
                ->orderBy($this->sortKolom, $this->sortOrder)
                ->get()
        ]);
    }
}