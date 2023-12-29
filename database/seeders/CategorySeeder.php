<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => [
                    'en' => 'Graphics & Design',
                    'ar' => 'تصاميم و رسومات'
                ],
                'slug' => str('Graphics & Design')->slug()
            ],
            [
                'name' => [
                    'en' => 'Digital Marketing',
                    'ar' => 'التسويق الرقمي'
                ],
                'slug' => str('Digital Marketing')->slug()
            ],
            [
                'name' => [
                    'en' => 'Web Applications',
                    'ar' => 'تطبيقات مواقع'
                ],
                'slug' => str('Web Applications')->slug()
            ],
            [
                'name' => [
                    'en' => 'Desktop Application',
                    'ar' => 'تطبيقات سطح مكتب'
                ],
                'slug' => str('Desktop Application')->slug()
            ],
            [
                'name' => [
                    'en' => 'Mobile Application',
                    'ar' => 'تطبيقات جوال'
                ],
                'slug' => str('Mobile Application')->slug()
            ],
            [
                'name' => [
                    'en' => 'Logo Design',
                    'ar' => 'تصميم لوجو'
                ],
                'slug' => str('Logo Design')->slug()
            ],
            [
                'name' => [
                    'en' => 'Illustrations',
                    'ar' => 'الرسوم التوضيحية'
                ],
                'slug' => str('Illustrations')->slug()
            ],
            [
                'name' => [
                    'en' => 'Videos & Animations',
                    'ar' => 'فيديو ورسوم متحركة'
                ],
                'slug' => str('Videos & Animations')->slug()
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
