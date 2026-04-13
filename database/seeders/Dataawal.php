<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Produk;
use Illuminate\Support\Facades\Hash;

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

        
        $produk = [
            [
                'kode_produk' => 'PRD001',
                'nama_produk' => 'Kopi Kapal Api 165gr',
                'harga' => 15000,
                'stok' => 50,
            ],
            [
                'kode_produk' => 'PRD002',
                'nama_produk' => 'Indomie Goreng',
                'harga' => 3500,
                'stok' => 100,
            ],
            [
                'kode_produk' => 'PRD003',
                'nama_produk' => 'Teh Botol Sosro 450ml',
                'harga' => 6000,
                'stok' => 25,
            ],
            [
                'kode_produk' => 'PRD004',
                'nama_produk' => 'Susu Ultra Chocolate 250ml',
                'harga' => 7000,
                'stok' => 30,
            ],
            [
                'kode_produk' => 'PRD005',
                'nama_produk' => 'Chitato Sapi Panggang',
                'harga' => 12500,
                'stok' => 15,
            ],
        ];

        foreach ($produk as $item) {
            Produk::create($item);
        }
    }
}