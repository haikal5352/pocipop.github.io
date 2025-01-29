<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('produk')->insert([
            [
                'name' => 'Hazelnut Jerman',
                'img' => '1.jpg',
                'price' => 18000,
                'level' => 'Medium',
                'description' => 'Kopi dengan aroma kacang hazelnut khas Jerman yang lembut. Perpaduan sempurna antara biji kopi pilihan dan essence hazelnut premium menghasilkan cita rasa yang unik dan memikat.',
                'isFlipped' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kopi Nusantara',
                'img' => '2.jpg',
                'price' => 25000,
                'level' => 'Strong',
                'description' => 'Racikan kopi lokal terbaik dari berbagai penjuru Nusantara. Memiliki karakter kuat dengan sentuhan rempah tradisional Indonesia.',
                'isFlipped' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Arabica Blend',
                'img' => '3.jpg',
                'price' => 38000,
                'level' => 'Medium-Strong',
                'description' => 'Perpaduan biji arabika berkualitas tinggi yang menghasilkan cita rasa seimbang dengan tingkat keasaman yang pas dan aroma yang menggoda.',
                'isFlipped' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Americano Late',
                'img' => '4.jpg',
                'price' => 45000,
                'level' => 'Medium',
                'description' => 'Espresso yang dipadukan dengan air panas, menghasilkan kopi yang ringan namun tetap kaya akan cita rasa. Cocok untuk pecinta kopi yang menginginkan caffeine boost.',
                'isFlipped' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
} 