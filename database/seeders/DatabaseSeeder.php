<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear un usuario administrador
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Crear algunos usuarios normales
        User::factory(5)->create();

        // Ejecutar el seeder de categorías
        $this->call(CategorySeeder::class);

        // Crear productos de prueba usando categorías existentes
        $categories = \App\Models\Category::all();
        foreach ($categories as $category) {
            Product::factory(3)->create([
                'category_id' => $category->id
            ]);
        }
    }
}
