<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'SPK TRANSPORT',
                'description' => 'Dokumen SPK Transport',
            ],
            [
                'name' => 'SPK PANEN',
                'description' => 'Dokumen SPK Panen',
            ],
            [
                'name' => 'SPK RAWAT BORONGAN',
                'description' => 'Dokumen SPK Rawat Borongan',
            ],
            [
                'name' => 'SPK KARYAWAN',
                'description' => 'Dokumen perjanjian dan kontrak',
            ],
            [
                'name' => 'Others',
                'description' => 'Dokumen lainnya yang tidak termasuk kategori di atas',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}