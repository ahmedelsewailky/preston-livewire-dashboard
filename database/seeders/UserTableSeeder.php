<?php

namespace Database\Seeders;

use App\Models\User;
use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Role, Permission};

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!file_exists(public_path('storage/users'))) {
            mkdir(public_path('storage/users'), 0777, true);
        }

        Avatar::create('admin')->save(public_path('storage/users/admin.png'));
        Avatar::create('mostafa')->save(public_path('storage/users/mostafa.png'));
        Avatar::create('ramy')->save(public_path('storage/users/ramy.png'));

        $user = User::create([
            'name' => 'Ahmed Elsewailky',
            'username' => 'owner',
            'password' => bcrypt('password'),
            'phone' => '01275222108',
            'email' => 'admin@yahoo.com',
            'image' => 'users/admin.png'
        ]);

        $user->assignRole('owner');

        $superAdmin = User::create([
            'name' => 'Mostafa Moshrafa',
            'username' => 'superadmin',
            'password' => bcrypt('password'),
            'phone' => '01089562356',
            'email' => 'mostafa@yahoo.com',
            'image' => 'users/mostafa.png'
        ]);

        $superAdmin->assignRole('super-admin');

        $superAdmin = User::create([
            'name' => 'Ramy Elmasry',
            'username' => 'admin',
            'password' => bcrypt('password'),
            'phone' => '01178451245',
            'email' => 'ramy@yahoo.com',
            'image' => 'users/ramy.png'
        ]);

        $superAdmin->assignRole('admin');
    }
}
