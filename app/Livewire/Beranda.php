<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\User;

class Beranda extends Component
{
    public function render()
    {
        return view('livewire.beranda', [
            'totalTransaksi' => Transaksi::count(),
            'totalProduk'    => Produk::count(),
            'totalUser'      => User::count(),
            'totalKeuntungan' => Transaksi::sum('total_harga'),
        ]);
    }
}