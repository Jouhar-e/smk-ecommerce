<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;

class StoreProfileSeeder extends Seeder
{
    public function run(): void
    {
        if (Profile::count() == 0) {
            Profile::create([
                'store_name'  => 'Toko SMK Jaya',
                'tagline'     => 'Belajar Bisnis Sejak Bangku Sekolah',
                'description' => 'E-commerce latihan untuk siswa SMK, berfokus pada produk karya siswa.',
                'logo_path'   => null,
                'address'     => 'Jl. Pendidikan No. 123, Kota Contoh',
                'phone'       => '081234567890',
                'email'       => 'tokosmk@example.com',
                'instagram'   => 'https://instagram.com/tokosmk',
                'facebook'    => null,
                'tiktok'      => null,
                'open_hours'  => '08.00 - 17.00',
            ]);
        }
    }
}
