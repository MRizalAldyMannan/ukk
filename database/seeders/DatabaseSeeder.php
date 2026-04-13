<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// Tanpa WithoutModelEvents juga tidak apa-apa untuk seeder manual

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Pastikan 'A' pada DataAwal besar jika nama filenya DataAwal.php
        $this->call(DataAwal::class);
    }
}
