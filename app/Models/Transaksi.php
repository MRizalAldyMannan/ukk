<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['kode_transaksi', 'total_harga', 'status'];

    
    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id', 'id');
    }
}