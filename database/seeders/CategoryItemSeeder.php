<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Item;

class CategoryItemSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            'Makanan',
            'Minuman',
        ];

        foreach ($kategori as $nama) {
            $category = Category::firstOrCreate(['category' => $nama]);

            // Item::factory()->count(5)->create([
            //     'category_id' => $category->id,
            // ]);
        }
    }
}

