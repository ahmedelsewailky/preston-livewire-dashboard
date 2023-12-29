<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'php',
            'laravel',
            'livewire',
            'volt',
            'bootstrap',
            'tailwindcss',
            'jquery',
            'aplinejs',
            'vue',
            'react',
            'angular',
            'nextjs',
            'nodejs',
            'paython',
            'html',
            'css',
            'admin',
            'dashboard',
            'website',
            'cpanel',
            'wordpress',
        ];

        foreach ($tags as $tag) {
            \App\Models\tag::create([
                'name' => [
                    'en' => $tag,
                    'ar' => $tag
                ],
                'slug' => str($tag)->slug()
            ]);
        }
    }
}
