<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        // Crear 5 posts únicos
        Post::factory()->count(5)->create();
    }
}