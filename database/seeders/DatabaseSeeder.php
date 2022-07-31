<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create([
            'name' => 'hr alamin',
            'type' => 'admin',
            'email' => 'hralamin2020@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('000000')
        ]);
        \App\Models\Category::factory(10)->create()->each(function ($category) {
            \App\Models\Post::factory(10)->create([
                'category_id' => $category->id
            ]);
        });
    }
}
