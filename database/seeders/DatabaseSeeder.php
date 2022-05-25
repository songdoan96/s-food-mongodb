<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
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
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Admin Name',
            'email' => 'admin@gmail.com',
            'password' => Hash::make("admin"),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'User Name',
            'email' => 'user@gmail.com',
            'password' => Hash::make("user"),
            'role' => 'user',
        ]);
        User::create([
            'name' => 'User Name 2',
            'email' => 'user2@gmail.com',
            'password' => Hash::make("user"),
            'role' => 'user',
        ]);
        User::create([
            'name' => 'User Name 3',
            'email' => 'user3@gmail.com',
            'password' => Hash::make("user"),
            'role' => 'user',
        ]);
    }
}
