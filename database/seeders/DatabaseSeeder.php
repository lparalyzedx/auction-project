<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'admin@test.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        User::factory()->create([
            'name'     => 'Test Satıcı',
            'email'    => 'seller@test.com',
            'password' => bcrypt('password'),
            'role'     => 'seller',
        ]);

        Category::insert([
            ['name' => 'Elektronik',  'slug' => 'elektronik',  'is_active' => true, 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Antika',      'slug' => 'antika',      'is_active' => true, 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sanat',       'slug' => 'sanat',       'is_active' => true, 'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mücevherat',  'slug' => 'mucevherat',  'is_active' => true, 'sort_order' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
