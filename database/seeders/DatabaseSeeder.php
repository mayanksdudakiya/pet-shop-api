<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public const ADMIN_EMAIL = 'admin@buckhill.co.uk';
    public const ADMIN_PASSWORD = 'admin';

    public function run(): void
    {
        User::factory()->create([
            'email' => self::ADMIN_EMAIL,
            'password' => self::ADMIN_PASSWORD,
            'is_admin' => true,
        ]);

        User::factory()->create([
            'email' => 'user@gmail.com',
            'password' => 'userpassword',
        ]);

        User::factory(10)->create();
        Product::factory(15)->create();
        Order::factory(25)->create();
    }
}
