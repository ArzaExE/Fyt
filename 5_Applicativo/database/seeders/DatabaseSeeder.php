<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserRoles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        UserRoles::create([
            'id' => 1,
            'name' => 'admin'
        ]);

        UserRoles::create([
            'id' => 2,
            'name' => 'vendor'
        ]);

        UserRoles::create([
            'id' => 3,
            'name' => 'user'
        ]);

        User::create([
            'id' => 1,
            'name' => 'John',
            'surname' => 'Zillo',
            'username' => 'admin',
            'born_date' => '2000-01-01',
            'address' => 'Via Trevano 25',
            'postcode' => 6952,
            'city' => 'Canobbio',
            'country' => 'Svizzera',
            'phone' => '+41123456789',
            'email' => 'john.zillo@samtrevano.ch',
            'password' => Hash::make('admin'),
            'role_id' => 1
        ]);

        User::create([
            'id' => 2,
            'name' => 'Pier',
            'surname' => 'Telo',
            'username' => 'vendor',
            'born_date' => '2000-01-01',
            'address' => 'Via Trevano 25',
            'postcode' => 6952,
            'city' => 'Canobbio',
            'country' => 'Svizzera',
            'phone' => '+41123456789',
            'email' => 'pier.telo@samtrevano.ch',
            'password' => Hash::make('vendor'),
            'role_id' => 2
        ]);
        User::factory()->count(50)->create(); // Crea 50 utenti casuali
        Product::factory()->count(50)->create();
    }
}
