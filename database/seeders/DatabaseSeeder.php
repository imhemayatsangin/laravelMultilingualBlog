<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use App\Models\Language;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::factory()->create();
        Post::factory()->create();
        Language::factory()->create();
        $pashto = Language::factory()->create([
            'name' => 'پښتو',
            'code' => 'pa',
            'icon' => 'af',
            'rtl' => '0',
        ]);

        $dari = Language::factory()->create([
            'name' => 'دري',
            'code' => 'da',
            'icon' => 'af',
            'rtl' => '0',
        ]);

        $arabic = Language::factory()->create([
            'name' => 'Arabic',
            'code' => 'ar',
            'icon' => 'ae',
            'rtl' => '0',
        ]);
    }
}
