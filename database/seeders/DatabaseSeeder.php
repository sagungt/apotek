<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'username' => 'pemilik',
            'password' => bcrypt('pemilik'),
            'role' => 1,
        ]);
        \App\Models\User::create([
            'username' => 'gudang',
            'password' => bcrypt('gudang'),
            'role' => 2,
        ]);
        \App\Models\User::create([
            'username' => 'apoteker',
            'password' => bcrypt('apoteker'),
            'shared_password' => bcrypt('asisten apoteker'),
            'role' => 3,
        ]);

        for ($i = 1; $i <= 10; $i++) {
            \App\Models\Category::create([
                'nama_kategori' => 'Category ' . $i
            ]);

            \App\Models\Brand::create([
                'nama_merek' => 'Brand ' . $i
            ]);
        }
    }
}
