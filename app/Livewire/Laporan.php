<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaksi;
use Carbon\Carbon;

class Laporan extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Properti untuk rentang tanggal
    public $tgl_mulai;
    public $tgl_selesai;

    public function updatedTglMulai() { $this->resetPage(); }
    public function updatedTglSelesai() { $this->resetPage(); }

    public function render()
    {
        $query = Transaksi::with('detail.produk')->latest();

        // Filter Rentang Tanggal
        if ($this->tgl_mulai && $this->tgl_selesai) {
            // Kita gunakan startOfDay dan endOfDay agar mencakup seluruh jam di hari tersebut
            $query->whereBetween('created_at', [
                Carbon::parse($this->tgl_mulai)->startOfDay(),
                Carbon::parse($this->tgl_selesai)->endOfDay()
            ]);
        } elseif ($this->tgl_mulai) {
            $query->whereDate('created_at', '>=', $this->tgl_mulai);
        } elseif ($this->tgl_selesai) {
            $query->whereDate('created_at', '<=', $this->tgl_selesai);
        }

        return view('livewire.laporan', [
            'semuaTransaksi' => $query->paginate(5)
        ]);
    }
}