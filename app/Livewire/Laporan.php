<?php

namespace App\Livewire;

use Livewire\Component;

class Laporan extends Component
{
    public function mount()
    {
        if (auth()->user()->peran !== 'Admin') {
            abort(403, 'Akses Ditolak. Harus menggunakan akun Admin.');
        }
    }

    public function render()
    {
        $semuaTransaksi = \App\Models\Transaksi::with('detail.produk')->latest()->get();
        return view('livewire.laporan', compact('semuaTransaksi'));
    }
}