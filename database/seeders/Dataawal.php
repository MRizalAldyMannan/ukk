<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class Dataawal extends Seeder
{
    public function run(): void
    {
        
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'peran' => 'admin',
        ]);

      
        $produkData = [
            ['kode_produk' => 'PRD001', 'nama_produk' => 'Kopi Kapal Api 165gr', 'harga' => 15000, 'stok' => 50],
            ['kode_produk' => 'PRD002', 'nama_produk' => 'Indomie Goreng', 'harga' => 3500, 'stok' => 100],
            ['kode_produk' => 'PRD003', 'nama_produk' => 'Teh Botol Sosro 450ml', 'harga' => 6000, 'stok' => 25],
            ['kode_produk' => 'PRD004', 'nama_produk' => 'Susu Ultra Chocolate 250ml', 'harga' => 7000, 'stok' => 30],
            ['kode_produk' => 'PRD005', 'nama_produk' => 'Chitato Sapi Panggang', 'harga' => 12500, 'stok' => 15],
        ];

        foreach ($produkData as $item) {
            Produk::create($item);
        }

       
        $p1 = Produk::where('kode_produk', 'PRD001')->first();
        $p2 = Produk::where('kode_produk', 'PRD002')->first();
        $p4 = Produk::where('kode_produk', 'PRD004')->first();
        $p5 = Produk::where('kode_produk', 'PRD005')->first();

       
        $t1 = Transaksi::create([
            'kode_transaksi' => 'TRX-1776000001',
            'total_harga' => 30000,
            'status' => 'selesai',
            'created_at' => Carbon::create(2026, 4, 12, 10, 30, 0),
        ]);
        DetailTransaksi::create(['transaksi_id' => $t1->id, 'produk_id' => $p1->id, 'qty' => 2, 'harga' => $p1->harga]);

        
        $t2 = Transaksi::create([
            'kode_transaksi' => 'TRX-1776000002',
            'total_harga' => 7000,
            'status' => 'selesai',
            'created_at' => Carbon::create(2026, 4, 13, 8, 15, 0),
        ]);
        DetailTransaksi::create(['transaksi_id' => $t2->id, 'produk_id' => $p2->id, 'qty' => 2, 'harga' => $p2->harga]);

        
        $t3 = Transaksi::create([
            'kode_transaksi' => 'TRX-1776000003',
            'total_harga' => 25000,
            'status' => 'selesai',
            'created_at' => Carbon::create(2026, 4, 13, 14, 00, 0),
        ]);
        DetailTransaksi::create(['transaksi_id' => $t3->id, 'produk_id' => $p5->id, 'qty' => 2, 'harga' => $p5->harga]);

        
        $t4 = Transaksi::create([
            'kode_transaksi' => 'TRX-1776000004',
            'total_harga' => 14000,
            'status' => 'selesai',
            'created_at' => Carbon::create(2026, 4, 03, 17, 45, 0),
        ]);
        DetailTransaksi::create(['transaksi_id' => $t4->id, 'produk_id' => $p4->id, 'qty' => 2, 'harga' => $p4->harga]);
    }
}