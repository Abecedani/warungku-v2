<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['nama' => 'Makanan', 'warna' => '#f4511e'],
            ['nama' => 'Minuman', 'warna' => '#3b82f6'],
            ['nama' => 'Snack', 'warna' => '#f59e0b'],
            ['nama' => 'Promo', 'warna' => '#22c55e'],
            ['nama' => 'Paket', 'warna' => '#8b5cf6'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}